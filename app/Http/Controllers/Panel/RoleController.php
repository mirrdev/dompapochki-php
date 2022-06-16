<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Models\Permission;
use App\Http\Models\Role;
use App\Http\Models\RolePermissions;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Modules\IZColShower;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Role $role)
    {
        $this->middleware('auth');
        // set the model
        $this->model = new Repository($role);
    }

    public function index()
    {
        $grid = new IZColShower(
            trans('panel.role.header'),
            [
                'id' => trans('panel.id'),
                'display_name' => trans('panel.role.display_name'),
                'description' => trans('panel.description'),
            ],
            [
                'type' =>'collect',
                'items' => $this->model->all(),
            ],
            [
                'show' => 'role-show',
                'edit' => 'role-edit',
                'destroy' => 'role-destroy',
            ]
        );

        $grid->setHeaderActions([
            [
                'routers' => ['new' => 'role-create'],
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
            'item' => new Role(),
            'route' => route('role-store')
        ];
        return view('forms.form-role', $data);
    }

    public function store(CreateRoleRequest $request)
    {
        $this->validate($request, $request->rules());

        $model              =   $request->only($this->model->getModel()->fillable);

        // create record and pass in only fields that are fillable
        $this->model->create($model);

        return redirect(route('roles'));
    }

    public function show($id)
    {
        $item = $this->model->show($id);
        $show = new IZColShower(
            $item->display_name,
            [
                'id' => trans('panel.id'),
                'display_name' => trans('panel.role.display_name'),
                'description' => trans('panel.description'),
            ],
            [
                'type' =>'item',
                'item' => $item,
            ],
            [
                'edit' => 'role-edit',
                'destroy' => 'role-destroy',
            ]
        );

        $show->description = trans('panel.role.description');
        $show->setBreadcrumbs([
            [
                'text' => trans('panel.role.header'),
                'link' => route('roles')
            ],
            $item->display_name
        ]);

        $item = collect(['id' => -999, 'display_name' => implode(', ', Role::getPermissionsNames($id)) ]);

        $permissions = new IZColShower(
            trans('panel.permission.header'),
            [
                'display_name' => trans('panel.permissions'),
            ],
            [
                'type' =>'item',
                'item' => $item,
            ]
        );

        $data = [
            'content' => [
                $show,
                $permissions
            ],
        ];

        return view('grid.show', $data);
    }

    public function edit($id)
    {
        $item = $this->model->show($id);
        $permissionsRole = Role::getPermissions($id)->pluck('permission_id')->toArray();

        $data = [
            'title' => trans('panel.title'),
            'item' => $item,
            'route' => route('role-update', ['id' => $id]),
            'permissions' => Permission::all(),
            'permissionsRole' => $permissionsRole
        ];
        return view('forms.form-role', $data);
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $this->validate($request, $request->rules());

        $model              =   $request->only($this->model->getModel()->fillable);
        $permissionsOld = Role::getPermissions($id)->toArray();
        $permissionsNew = $request->only('permissions');
        $permissionsNew = $permissionsNew['permissions'];


        if(isset($permissionsNew) && count($permissionsNew) > 0)
        {
            foreach ($permissionsOld as $permission) {
                if(!in_array($permission, $permissionsNew))
                {
                    RolePermissions::where([
                        'permission_id' => $permission,
                        'role_id' => $id
                    ])->delete();
                }
            }

            foreach ($permissionsNew as $permission) {
                if(!in_array($permission, $permissionsOld))
                {
                    $newPermission = new RolePermissions();
                    $newPermission->role_id = $id;
                    $newPermission->permission_id = $permission;
                    $newPermission->save();
                }
            }
        }

        // update model and only pass in the fillable fields
        $this->model->update($model, $id);

        return redirect(route('role-show', $this->model->show($id)));
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $count = $this->model->delete($id);

        RolePermissions::where([
            'role_id' => $id
        ])->delete();

        if($count > 0)
        {
            return response()->json(route('roles'), 200);
        }
        else
        {
            return response()->json('error', 400);
        }
    }
}
