<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Time;
use NumberFormatter;
use App\Models\Pitch;
use App\Models\PitchArea;
use Illuminate\Http\Request;
use App\Enums\StatusPitchEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\ResponseTrait;

class PitchController extends Controller
{
    use ResponseTrait;

    public function index($pitchAreaId, Request $request): JsonResponse
    {
        try {
            // query eloquent
            $query = Pitch::query()
                ->where('pitch_area_id', $pitchAreaId);

            // process request
            if ($request->has('type')) {
                $currentType = $request->get('type');
                if ($currentType != -1) {
                    $query->where('type', $currentType);
                }
            }

            if ($request->has('status')) {
                $currentStatus = $request->get('status');
                if ($currentStatus != -1) {
                    $query->where('status', $currentStatus);
                }
            }

            // process avg price for the each type
            $arrTypes = DB::table('pitches')
                ->select('type')
                ->where('pitch_area_id', $pitchAreaId)
                ->distinct()
                ->get();
            $arrAvgCostType = [];
            foreach ($arrTypes as $each) {
                $arrAvgCostType[$each->type] = ceil(
                    Time::query()
                        ->where('pitch_area_id', $pitchAreaId)
                        ->where('type', $each->type)
                        ->avg('cost')
                );
            }

            $pitches = $query->get();

            // process result 
            $res = [];
            foreach ($pitches as $pitch) {
                $element['name'] = $pitch->name;
                $element['type'] = 'For ' . $pitch->type . ' human';
                $element['status'] = StatusPitchEnum::getKeyByValue($pitch->status);

                $element['avg_price'] = $arrAvgCostType[$pitch->type];
                

                $key = "VND";
                $locale = "vi_VN";
                $format = new NumberFormatter($locale, NumberFormatter::CURRENCY);
                $string = $format->formatCurrency($element['avg_price'], $key);
                $element['avg_price'] = $string;


                $res[] = $element;
            }
            return $this->successResponse($res);
        } catch (\Throwable $th) {
            dd($th);
            return $this->errorResponse($th);
        }
    }

    public function create($pitchAreaId)
    {
    }

    public function editPrice($pitchAreaId)
    {
        $pitchArea = PitchArea::where('id', $pitchAreaId)
            ->value('name');

        $types = Pitch::query()
            ->where('pitch_area_id', $pitchAreaId)
            ->distinct()
            ->pluck('type')
            ->toArray();

        $title = 'Pitchareas - ' . $pitchArea . ' - ' . 'Edit Price';

        return view('admin.pitch.editPrice', [
            'title' => $title,
            'types' => $types,
            'pitchAreaId' => $pitchAreaId,
        ]);
    }

    public function apiGetTimeSlotAndCost(Request $request, $pitchAreaId): JsonResponse
    {
        $pitch = Pitch::select('id')
            ->where('pitch_area_id', $pitchAreaId)
            ->where('type', $request->get('currentType'))
            ->with(['time' => function ($query) {
                $query->select('pitch_id', 'timeslot', 'cost');
            }])
            ->first();
        return $this->successResponse($pitch);
    }

    public function updateTimeSlotAndCost(Request $request, $pitchAreaId)
    {
        $currentTpe = $request->get('currentType');
        $arrTimeSlots = $request->get('addTimeslots');
        $arrCosts = $request->get('addCosts');

        $pitches = Pitch::select('id')
            ->where('pitch_area_id', $pitchAreaId)
            ->where('type', $currentTpe)
            ->get();
        foreach ($pitches as $pitch) {
        }
    }
}
