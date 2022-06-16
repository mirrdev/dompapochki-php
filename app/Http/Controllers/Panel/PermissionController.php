<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Models\Permission;
use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Modules\IZColShower;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Permission $permission)
    {
        $this->middleware('auth');
        // set the model
        $this->model = new Repository($permission);
    }

    public function index()
    {
        $grid = new IZColShower(
            trans('panel.permission.header'),
            [
                'id' => trans('panel.id'),
                'display_name' => trans('panel.display_name'),
                'description' => trans('panel.description'),
            ],
            [
                'type' =>'collect',
                'items' => $this->model->all(),
            ],
            [
                'show' => 'permission-show',
                'edit' => 'permission-edit',
                'destroy' => 'permission-destroy',
            ]
        );

        $grid->setHeaderActions([
            [
                'routers' => ['new' => 'permission-create'],
                'id' => null
            ]
        ]);

//        echo '<pre>';
//        print_r($grid);
//        echo '</pre>';
//        exit();

        $data = ['data' => $grid];

        return view('grid.panel', $data);
    }

    public function create()
    {
        $data = [
            'title' => trans('panel.title'),
            'item' => new Permission(),
            'route' => route('permission-store')
        ];
        return view('forms.form-permission', $data);
    }

    public function store(CreatePermissionRequest $request)
    {
        $this->validate($request, $request->rules());

        $model              =   $request->only($this->model->getModel()->fillable);

        // create record and pass in only fields that are fillable
        $this->model->create($model);

        return redirect(route('permissions'));
    }

    public function show($id)
    {
        $item = $this->model->show($id);
        $show = new IZColShower(
            $item->display_name,
            [
                'id' => trans('panel.id'),
                'display_name' => trans('panel.permission.display_name'),
                'description' => trans('panel.description'),
            ],
            [
                'type' =>'item',
                'item' => $item,
            ],
            [
                'edit' => 'permission-edit',
                'destroy' => 'permission-destroy',
            ]
        );

        $show->description = trans('panel.permission.description');
        $show->setBreadcrumbs([
            [
                'text' => trans('panel.permission.header'),
                'link' => route('permissions')
            ],
            $item->display_name
        ]);

        $data = ['content' => [
            $show
        ]];

        return view('grid.show', $data);
    }

    public function edit($id)
    {
        $item = $this->model->show($id);
        $data = [
            'title' => trans('panel.title'),
            'item' => $item,
            'route' => route('permission-update', ['id' => $id])
        ];
        return view('forms.form-permission', $data);
    }

    public function update(UpdatePermissionRequest $request, $id)
    {
        $this->validate($request, $request->rules());

        $model              =   $request->only($this->model->getModel()->fillable);

        // update model and only pass in the fillable fields
        $this->model->update($model, $id);

        return redirect(route('permission-show', $this->model->show($id)));
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $count = $this->model->delete($id);
        if($count > 0)
        {
            return response()->json(route('permissions'), 200);
        }
        else
        {
            return response()->json('error', 400);
        }
    }
}
