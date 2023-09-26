<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use NumberFormatter;
use App\Models\Pitch;
use Illuminate\Http\Request;
use App\Enums\StatusPitchEnum;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\ResponseTrait;

class PitchController extends Controller
{
    use ResponseTrait;
    public function index($pitchAreaId): JsonResponse
    {
        try {
            $pitches = Pitch::query()
                ->where('pitch_area_id', $pitchAreaId)
                ->with(['time' => function ($query) {
                    $query->select('pitch_id', 'timeslot', 'cost');
                }])
                ->get();

            // process result 
            $res = [];
            foreach ($pitches as $pitch) {
                $element['id'] = $pitch->id;
                $element['name'] = $pitch->name;
                $element['type'] = 'For ' . $pitch->type . ' human';
                $element['status'] = StatusPitchEnum::getKeyByValue($pitch->status);

                $element['avg_price'] = 0;
                foreach ($pitch->time as $each) {
                    $element['avg_price'] += (int)$each->value('cost');
                }

                $key = "VND";
                $locale = "vi_VN";
                $format = new NumberFormatter($locale, NumberFormatter::CURRENCY);
                $string = $format->formatCurrency($element['avg_price'], $key);
                $element['avg_price'] = $string;

                $res[] = $element;
            }
            return $this->successResponse($res);
        } catch (\Throwable $th) {
            return $this->errorResponse($th);
        }
    }
}
