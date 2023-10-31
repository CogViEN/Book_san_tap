<?php

namespace App\Http\Controllers\Owner;

use Carbon\Carbon;
use App\Models\Time;
use NumberFormatter;
use App\Models\Order;
use App\Models\Pitch;
use App\Models\PitchArea;
use App\Models\PitchTime;
use Illuminate\Http\Request;
use App\Enums\StatusOrderEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Trait\TitleTrait;
use App\Http\Controllers\Trait\ResponseTrait;
use App\Http\Requests\Appointment\StoreRequest;

class AppointmentController extends Controller
{
    use ResponseTrait;
    use TitleTrait;

    public function __construct()
    {

        $routerName = Route::currentRouteName();
        $title = ucfirst($this->getTitleRoute($routerName));

        View::share('title', $title);
    }

    public function index(Request $request)
    {
        // save old filter settings
        $oldFilterStatus = -9999;
        $oldFilterPitchArea = -9999;
        $oldFilterDate = -9999;

        // get all id of pitch areas belong to this user
        $query = PitchArea::select('id', 'name')
            ->where('user_id', auth()->user()->id);

        // process status array
        $arrStatus = StatusOrderEnum::getArrayView();
        // process pitch area array
        $arrPitchArea = $query->get();

        // process request pitch area
        if ($request->has('pitcharea')) {
            if ($request->pitcharea != 'All') {
                $query->where('id', $request->pitcharea);
                $oldFilterPitchArea = $request->pitcharea;
            }
        }


        $pitchAreas = $query->get();

        $arrId = [];

        foreach ($pitchAreas as $pitchArea) {
            // get all id of pitches belong to this pitch area
            $pitches = Pitch::select('id')
                ->where('pitch_area_id', $pitchArea->id)
                ->get();

            foreach ($pitches as $pitch) {
                $arrId[] = $pitch->id;
            }
        }

        $query = Order::query()
            ->with([
                'pitch' => function ($q) {
                    return $q->select([
                        'id',
                        'pitch_area_id',
                        'name',
                    ]);
                },
            ])
            ->whereIn('pitch_id', $arrId);

        // process request status
        if ($request->has('status') && $request->get('status') != 'All') {
            $query = $query->where('status', $request->status);
            $oldFilterStatus = $request->status;
        }

        // process request date
        if ($request->has('date') && $request->get('date') != 'All') {
            if ($request->date == 0) $query = $query->whereDate('created_at', Carbon::today());
            else if ($request->date == 1) $query = $query->whereDate('created_at', Carbon::yesterday());
            else $query = $query->whereDate('created_at', '>', Carbon::now()->subDays($request->date));
            $oldFilterDate = $request->date;
        }


        // result
        $orders = $query->latest()
            ->paginate(4);

        foreach ($orders as $order) {
            // format data
            $order->pitch->name_pitch = getNamePitchArea($order->pitch->pitch_area_id);

            $key = "VND";
            $locale = "vi_VN";
            $format = new NumberFormatter($locale, NumberFormatter::CURRENCY);
            $order->price = $format->formatCurrency($order->price, $key);

            $order->status = StatusOrderEnum::getKeyByValue($order->status);

            if (is_null($order->require)) {
                $order->require = 'not thing';
            }
        }


        return view('owner.appointment.index', [
            'orders' => $orders,
            'arrPitchArea' => $arrPitchArea,
            'arrStatus' => $arrStatus,
            'oldFilterPitchArea' => $oldFilterPitchArea,
            'oldFilterStatus' => $oldFilterStatus,
            'oldFilterDate' => $oldFilterDate,
        ]);
    }

    public function abort($id)
    {
        try {
            DB::table('orders')
                ->where('id', $id)
                ->update(['status' => StatusOrderEnum::ABORT]);

            return $this->successResponse();
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function accept($id)
    {
        try {
            DB::table('orders')
                ->where('id', $id)
                ->update(['status' => StatusOrderEnum::ACCEPT]);

            return $this->successResponse();
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function create()
    {
        return view('owner.appointment.create');
    }

    public function store(StoreRequest $request)
    {
        $arr = $request->validated();
        try{
            // split time slot
            $arrTimeSlot = explode(' ', $arr['timeslots']);
            
            // get type from pitch
            $type = Pitch::where('id', $request->pitch)
                            ->value('type');
            
            // get cost from times
            $arrCost = Time::select('timeslot', 'cost')
                            ->where('pitch_area_id', $request->pitcharea)
                            ->where('type', $type)
                            ->whereIn('timeslot', $arrTimeSlot)
                            ->get();
            
            // save order records
            foreach($arrCost as $each){
                Order::create([
                    'name' => $arr['name'],
                    'phone' => $arr['phone'],
                    'price' => $each->cost,
                    'status' => StatusOrderEnum::PROCESSING,
                    'require' => $arr['require'],
                    'pitch_id' => $arr['pitch'],
                    'timeslot' => $each->timeslot,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString()
                ]);

                PitchTime::create([
                    'pitch_id' => $arr['pitch'],
                    'timeslot' => $each->timeslot,
                    'will_do' => $arr['willdo'],
                ]);
            
                
            }
            return $this->successResponse();

        }catch (\Throwable $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getTimeslotFree(Request $request): JsonResponse
    {
       

        // get pitch area id and type to process next step
        $pitch = Pitch::select('pitch_area_id', 'type')
            ->where('id', $request->pitchId)
            ->first();
        
         // catch object not of this owner
         if(!checkPitchAreaBelongThisUser(auth()->user()->id, $pitch->pitch_area_id)){
            return $this->errorResponse('mày đùa với bố m à');
        }

        // get will do and timeslot in pitch times
        $pitch_time = PitchTime::select('timeslot')
            ->where('pitch_id', $request->pitchId)
            ->where('will_do', $request->willdo)
            ->get()
            ->toArray();

        $times = Time::select('timeslot', 'cost')
            ->where('pitch_area_id', $pitch->pitch_area_id)
            ->where('type', $pitch->type)
            ->whereNotIn('timeslot', $pitch_time)
            ->get();
        
        return $this->successResponse($times);
    }

}
