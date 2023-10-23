<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Enums\StatusPostEnum;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Controllers\Trait\TitleTrait;
use App\Http\Controllers\Trait\ResponseTrait;

class PostController extends Controller
{
    use ResponseTrait;
    use TitleTrait;
    private object $model;
    private string $table;

    public function __construct()
    {
        $this->model = Post::query();

        $routerName = Route::currentRouteName();
        $title = ucfirst($this->getTitleRoute($routerName));

        View::share('title', $title);
    }

    public function index(Request $request)
    {
        $query = $this->model
            ->where('status', '!=', -1);

        if ($request->has('status')) {
            if ($request->get('status') != 'All') {
                if ($request->get('status') == 'Pending') {
                    $query->where('status', StatusPostEnum::PENDING);
                } else if ($request->get('status') == 'Accepted') {
                    $query->where('status', StatusPostEnum::ACCEPT);
                }
            }
        }

        $arr = $query->paginate(2);

        return view('admin.post.index', [
            'arr' => $arr,
        ]);
    }

    public function create()
    {
        return view('admin.post.create');
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $arr = $request->validated();

            // process image
            $destination_path = 'public/images/post_avatar/' . time() . '-' . $arr['heading'];
            $image = $request->file('avatar');
            $image_name = $image->getClientOriginalName();
            $path = $request->file('avatar')->storeAs($destination_path, $image_name);
            $getHost = request()->getHost();

            $arr['avatar'] =  $getHost . '/storage/images/post_avatar/' . time() . '-' . $arr['heading'] . '/' . $image_name;

            Post::create([
                'user_id' => auth()->user()->id,
                'heading' => $arr['heading'],
                'description' => $arr['description'],
                'avatar' => $arr['avatar'],
                'status' => StatusPostEnum::ACCEPT,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);

            DB::commit();
            return $this->successResponse('Successfully created');
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    public function show($postId)
    {
        $post = Post::query()
            ->where('id', $postId)
            ->first();

        return view('admin.post.show', [
            'post' => $post,
        ]);
    }

    public function accept(Request $request)
    {
        try {
            DB::table('posts')
                ->where('id', $request->id)
                ->where('status', StatusPostEnum::PENDING)
                ->update(['status' => StatusPostEnum::ACCEPT]);

            return $this->successResponse();
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function abort(Request $request)
    {
        try {
            Post::where('id', $request->id)
                ->where(function ($query) {
                    $query->where('status', StatusPostEnum::PENDING)
                        ->orWhere('status', StatusPostEnum::ACCEPT);
                })
                ->update(['status' => StatusPostEnum::ABORT]);

            return $this->successResponse();
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
