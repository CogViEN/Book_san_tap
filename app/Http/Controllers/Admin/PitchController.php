<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use NumberFormatter;
use App\Models\Pitch;
use App\Models\PitchArea;
use Illuminate\Http\Request;
use App\Enums\StatusPitchEnum;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\ResponseTrait;

class PitchController extends Controller
{
    use ResponseTrait;

    public function index($pitchAreaId, Request $request): JsonResponse
    {
        try {
            $query = Pitch::query()
                ->where('pitch_area_id', $pitchAreaId)
                ->with(['time' => function ($query) {
                    $query->select('pitch_id', 'timeslot', 'cost');
                }]);

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

            $pitches = $query->get();

            // process result 
            $res = [];
            foreach ($pitches as $pitch) {
                $element['id'] = $pitch->id;
                $element['name'] = $pitch->name;
                $element['type'] = 'For ' . $pitch->type . ' human';
                $element['status'] = StatusPitchEnum::getKeyByValue($pitch->status);

                $element['avg_price'] = 0;
                $i = 0;
                foreach ($pitch->time as $each) {
                    $element['avg_price'] += (int)$each->value('cost');
                    $i++;
                }

                $element['avg_price'] /= $i;

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

    public function create($pitchAreaId)
    {
    }

    public function editPrice($pitchAreaId)
    {
        $pitchArea = PitchArea::where('id', $pitchAreaId)
            ->value('name');


        $title = 'Pitchareas - ' . $pitchArea . ' - ' . 'Edit Price';

        return view('admin.pitch.editPrice', [
            'title' => $title,
        ]);
    }
}
