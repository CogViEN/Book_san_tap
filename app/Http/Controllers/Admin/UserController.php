<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    private object $model;
    private string $table;

    public function __construct()
    {
        $this->model = User::query();
        $this->table = (new User())->getTable();

        View::share('title', ucfirst($this->table));
        View::share('table', $this->table);
    }

    public function index()
    {
        return view('admin.user.index');
    }

    public function api()
    {
        return Datatables::of($this->model)
            ->addColumn('edit', function ($object){
                return route('admin.users.edit', $object);
            })
            ->addColumn('destroy', function ($object){
                return route('admin.users.destroy', $object);
            })
            ->make(true);
    }
}
