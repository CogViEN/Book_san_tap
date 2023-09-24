<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\User;
use App\Models\Image;
use App\Models\PitchArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
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

        View::share('title', ucfirst($this->getTitleRoute($routerName)));
    }

    public function index()
    {
        return view('admin.pitch_area.index');
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
                                'path' => $getHost . '/storage/images/pitch/' . $path,
                                'type' => 1,
                            ]);
                        }
                    } else {
                        $destination_path = 'public/images/pitch/' . $request->name;
                        $image_name = $image->getClientOriginalName();
                        $path = $image->storeAs($destination_path, $image_name);
                        Image::create([
                            'object-id' => $pitchArea->id,
                            'path' => $getHost . '/storage/images/pitch/' . $path,
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
}
