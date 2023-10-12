<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Time;
use NumberFormatter;
use App\Models\Pitch;
use App\Models\PitchArea;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Enums\StatusPitchEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Pitch\StoreRequest;
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
                        ->whereNull('deleted_at')
                        ->avg('cost')
                );
            }

            $pitches = $query->get();

            // process result 
            $res = [];
            foreach ($pitches as $pitch) {
                $element['name'] = $pitch->name;
                $element['type'] = 'For ' . $pitch->type . ' human';
                if ($pitch->type == 6) {
                    $element['type'] = 'Fusal';
                }
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

    public function store(StoreRequest $request, $pitchAreaId)
    {
        Pitch::firstOrCreate([
            'pitch_area_id' => $pitchAreaId,
            'name' => $request->get('pitch-name'),
            'type' => $request->get('type'),
        ], [
            'status' => StatusPitchEnum::ACTIVE,
        ]);
        return $this->successResponse();
    }

    public function destroy(Request $request, $pitchAreaId)
    {
        Pitch::where([
            'pitch_area_id' => $pitchAreaId,
            'name' => $request->name,
        ])->delete();
        return $this->successResponse();
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
        $res = Time::query()
            ->where('pitch_area_id', $pitchAreaId)
            ->where('type', $request->get('currentType'))
            ->whereNull('deleted_at')
            ->orderBy('timeslot', 'ASC')
            ->get();
        return $this->successResponse($res);
    }

    public function updateTimeSlotAndCost(Request $request, $pitchAreaId)
    {
        $check = PitchArea::where('id', $pitchAreaId)->first();
        if (is_null($check)) {
            return $this->errorResponse('Cdmmm sửa cái lonnnzzzz');
        }

        try {
            $currentType = $request->get('currentType');
            $arrTimeSlots = $request->get('addTimeslots');
            $arrCosts = $request->get('addCosts');

            $lengthTimeSlot = count($arrTimeSlots);
            for ($i = 0; $i < $lengthTimeSlot; $i++) {
                $timeslot =  implode("", array_values($arrTimeSlots[$i]));
                $cost = implode("", array_values($arrCosts[$i]));

                $time = Time::query()
                    ->where('pitch_area_id', $pitchAreaId)
                    ->where('type', $currentType)
                    ->where('timeslot', $timeslot)
                    ->whereNull('deleted_at')
                    ->first();
                if (is_null($time)) {
                    Time::create([
                        'pitch_area_id' => $pitchAreaId,
                        'type' => $currentType,
                        'timeslot' => $timeslot,
                        'cost' => $cost,
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]);
                } else {

                    if ($time->cost != $cost) {
                        Time::where('pitch_area_id', $pitchAreaId)
                            ->where('type', $currentType)
                            ->where('timeslot', $timeslot)
                            ->whereNull('deleted_at')
                            ->update(['deleted_at' => \Carbon\Carbon::now()->toDateTimeString()]);

                        Time::create([
                            'pitch_area_id' => $pitchAreaId,
                            'type' => $currentType,
                            'timeslot' => $timeslot,
                            'cost' => $cost,
                            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        ]);
                    }
                }
            }
            return $this->successResponse();
        } catch (\Throwable $e) {
            dd($e);
            return $this->errorResponse();
        }
    }
}
