<?php

namespace App\Http\Controllers\EndUser;

use App\Models\Time;
use NumberFormatter;
use App\Models\Image;
use App\Models\Pitch;
use App\Models\PitchArea;
use App\Enums\PitchTypeEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\ResponseTrait;

class HomepageController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {

        $pitchareas = PitchArea::select('id', 'name', 'address')
            ->with([
                'pitch' => function ($q) {
                    return $q->select([
                        'pitch_area_id',
                        'type',
                    ])
                        ->distinct();
                },
            ]);


        // process request province and district
        $selectProvince = 'All';
        $selectDistrict = 'All';
        $curDistrict = [];
        if ($request->has('province') && $request->get('province') != 'All') {
            $pitchareas = $pitchareas->where('province', $request->get('province'))
                ->where('district', $request->get('district'));

            $selectProvince = $request->get('province');
            $selectDistrict = $request->get('district');
            $curDistrict = PitchArea::select('district')
                ->where('province', $selectProvince)
                ->pluck('district');
        }

        // process request type
        $curTypes = [];
        if ($request->has('types')) {
            $curTypes = $request->get('types');
           $pitchareas->whereHas('pitch', function ($q) use ($curTypes) {
                return $q->whereIn('type', $curTypes);
           });
        }

        // get the result after process request
        $pitchareas = $pitchareas->get();

         

        // format data for output
        foreach ($pitchareas as $pitcharea) {

            // format currency cost
            $key = "VND";
            $locale = "vi_VN";
            $format = new NumberFormatter($locale, NumberFormatter::CURRENCY);

            $minCost = Time::where('pitch_area_id', $pitcharea->id)
                ->min('cost');
            $minCost = $format->formatCurrency($minCost, $key);

            $maxCost = Time::where('pitch_area_id', $pitcharea->id)
                ->max('cost');
            $maxCost = $format->formatCurrency($maxCost, $key);


            $pitcharea->cost = $minCost . ' - ' . $maxCost;


            // get avatar
            $pitcharea->avatar = Image::where('object-id', $pitcharea->id)
                ->where('type', 1)
                ->pluck('path')
                ->first();
        }

        // get province pitch area
        $cities = PitchArea::select('province')
            ->distinct()
            ->pluck('province');

        // get types in the pitch areas
        $types = getCacheTypePitch();

        return view('frontpage.index', [
            'pitchareas' => $pitchareas,
            'cities' => $cities,
            'types' => $types,
            'selectProvince' => $selectProvince,
            'selectDistrict' => $selectDistrict,
            'currentDistrict' => $curDistrict,
            'curTypes' => $curTypes,
        ]);
    }

    public function apiPitchArea(Request $request)
    {

        $pitchareas = PitchArea::select('id', 'name', 'address')
            ->with([
                'pitch' => function ($q) {
                    return $q->select([
                        'pitch_area_id',
                        'type',
                    ])->distinct();
                },
            ]);

        // process request province and district
        if ($request->has('province') && $request->get('province') != 'All') {
            $pitchareas = $pitchareas->where('province', $request->get('province'))
                ->where('district', $request->get('district'));
        }

        // process request type
        if ($request->has('types')) {
           $curTypes = $request->get('types');
           $pitchareas->whereHas('pitch', function ($q) use ($curTypes) {
                return $q->whereIn('type', $curTypes);
           });
        }

        // get the result after process request
        $pitchareas = $pitchareas->get();


        // format data for output
        foreach ($pitchareas as $pitcharea) {

            // format currency cost
            $key = "VND";
            $locale = "vi_VN";
            $format = new NumberFormatter($locale, NumberFormatter::CURRENCY);

            $minCost = Time::where('pitch_area_id', $pitcharea->id)
                ->min('cost');
            $minCost = $format->formatCurrency($minCost, $key);

            $maxCost = Time::where('pitch_area_id', $pitcharea->id)
                ->max('cost');
            $maxCost = $format->formatCurrency($maxCost, $key);


            $pitcharea->cost = $minCost . ' - ' . $maxCost;


            // get avatar
            $pitcharea->avatar = Image::where('object-id', $pitcharea->id)
                ->where('type', 1)
                ->pluck('path')
                ->first();

            // format type
            $pitcharea->type = 'Includes: ';
            foreach ($pitcharea->pitch as $_pitch) {
                $pitcharea->type .= PitchTypeEnum::getKeyByValue($_pitch->type) . ' ,';
            }
            $pitcharea->type = substr_replace($pitcharea->type, "", -1);
        }

        return $this->successResponse($pitchareas);
    }

    public function getCityAndDistrict()
    {
        $objects = PitchArea::select('province', 'district')
            ->distinct()
            ->get();

        return $this->successResponse($objects);
    }
}
