<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\User;
use App\Models\Image;
use App\Models\PitchArea;
use App\Imports\PitchImport;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Trait\TitleTrait;
use App\Http\Controllers\Trait\ResponseTrait;
use App\Http\Requests\PitchArea\StoreRequest;

class PitchAreaController extends Controller
{
    use ResponseTrait;
    use TitleTrait;
    private object $model;
    private string $table;

    public function __construct()
    {
        $this->model = PitchArea::query();
        $this->table = (new PitchArea())->getTable();

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

        return view('admin.pitch_area.index', [
            'arrPitchArea' => $arrPitchArea,
            'arrImage' => $arrImage,
            'arrOwner' => $arrOwner,
        ]);
    }

    public function create()
    {
        return view('admin.pitch_area.create');
    }

    public function store(StoreRequest $request)
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
            $arr['user_id'] = User::firstOrCreate(['name' => $owner])->id;

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
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    public function showPitch($pitchAreaId)
    {
        $pitchArea = PitchArea::where('id', $pitchAreaId)
            ->value('name');

        if ($pitchArea == null) {
            return redirect()->route('admin.pitchareas.index');
        }

        $arrStatus = getCacheStatusPitch();
        $arrType = getCacheTypePitch();

        $title = 'Pitchareas - ' . $pitchArea;

        return view('admin.pitch.show', [
            'title' => $title,
            'pitchAreaId' => $pitchAreaId,
            'arrStatus' => $arrStatus,
            'arrType' => $arrType,
        ]);
    }

    public function importCSV(Request $request, $pitchAreaId): JsonResponse
    {
        try {
            Excel::import(new PitchImport($pitchAreaId), $request->file('file'));
            return $this->successResponse();
        } catch (\Throwable $th) {
            return $this->errorResponse();
        }
    }
}
