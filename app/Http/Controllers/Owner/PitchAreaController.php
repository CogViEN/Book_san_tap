<?php

namespace App\Http\Controllers\Owner;

use App\Models\User;
use App\Models\Image;
use App\Models\PitchArea;
use App\Imports\TimeImport;
use App\Imports\PitchImport;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Trait\TitleTrait;
use App\Http\Controllers\Trait\ResponseTrait;
use App\Http\Requests\PitchArea\StoreRequestByOwner;

class PitchAreaController extends Controller
{
    use ResponseTrait;
    use TitleTrait;
    private object $model;
    private string $table;

    public function __construct()
    {
        $this->model = PitchArea::query()
            ->where('user_id', auth()->user()->id);

        $routerName = Route::currentRouteName();
        $title = ucfirst($this->getTitleRoute($routerName));

        View::share('title', $title);
    }

    public function index()
    {
        $arrPitchArea = $this->model->paginate(1);
        $arrImage = [];
        $arrOwner = [];

        for ($i = 0; $i < count($arrPitchArea); $i++) {
            $arrImage[$i] = Image::where('object-id', $arrPitchArea[$i]->id)->first()->path;
            $arrOwner[$i] = User::where('id', $arrPitchArea[$i]->user_id)->first()->info;
        }

        return view('owner.pitch_area.index', [
            'arrPitchArea' => $arrPitchArea,
            'arrImage' => $arrImage,
            'arrOwner' => $arrOwner,
        ]);
    }

    public function create()
    {
        return view('owner.pitch_area.create');
    }

    public function store(StoreRequestByOwner $request)
    {
        DB::beginTransaction();
        try {
            $arr = $request->validated();

            $arrImageRemove = [];
            $checkImgRemoveExist = false;
            if (!is_null($request->get('imageRemove'))) {
                $arrImageRemove = explode(',', $request->get('imageRemove'));
                $checkImgRemoveExist = true;
            }

            $owner = $request->get('owner');
            $arr['user_id'] = auth()->user()->id;

            $pitchArea = PitchArea::create($arr);

            // process the request image
            $getHost = request()->getHost();
            if ($request->has('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $flag = true; // check if the image in image remove
                    if ($checkImgRemoveExist == true) {
                        foreach ($arrImageRemove as $imageRemove) {
                            if ($imageRemove == $image->getClientOriginalName()) {
                                $flag = false;
                                break;
                            }
                        }
                        if ($flag == true) {
                            $destination_path = 'public/images/pitch/' . $request->name;
                            $image_name = $image->getClientOriginalName();
                            $path = $image->storeAs($destination_path, $image_name);
                            Image::create([
                                'object-id' => $pitchArea->id,
                                'path' => $getHost . '/storage/images/pitch/' . $request->name . '/' . $image_name,
                                'type' => 1,
                            ]);
                        }
                    } else {
                        $destination_path = 'public/images/pitch/' . $request->name;
                        $image_name = $image->getClientOriginalName();
                        $path = $image->storeAs($destination_path, $image_name);
                        Image::create([
                            'object-id' => $pitchArea->id,
                            'path' => $getHost . '/storage/images/pitch/' . $request->name . '/' . $image_name,
                            'type' => 1,
                        ]);
                    }
                }
            }

            DB::commit();
            return $this->successResponse();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    public function showPitch($pitchAreaId)
    {
        // check if pitch area is belong to this users
        if (!checkPitchAreaBelongThisUser(auth()->user()->id, $pitchAreaId)) {
            return redirect()->route('owner.pitchareas.index');
        }

        // check if pitch area is exists
        $pitchArea = PitchArea::where('id', $pitchAreaId)
            ->value('name');

        if ($pitchArea == null) {
            return redirect()->route('owner.pitchareas.index');
        }

        $arrStatus = getCacheStatusPitch();
        $arrType = getCacheTypePitch();

        $title = 'Pitchareas - ' . $pitchArea;

        return view('owner.pitch.show', [
            'title' => $title,
            'pitchAreaId' => $pitchAreaId,
            'arrStatus' => $arrStatus,
            'arrType' => $arrType,
        ]);
    }

    public function getPitchArea()
    {
        $pitchArea = PitchArea::select('id', 'name')
            ->where('user_id', auth()->user()->id)
            ->get();

        return $this->successResponse($pitchArea);
    }

    public function importCSVPitch(Request $request, $pitchAreaId): JsonResponse
    {
        try {
            Excel::import(new PitchImport($pitchAreaId), $request->file('file'));
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }

    public function importCSVTime(Request $request, $pitchAreaId): JsonResponse
    {
        try {
            Excel::import(new TimeImport($pitchAreaId), $request->file('file'));
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }
}
