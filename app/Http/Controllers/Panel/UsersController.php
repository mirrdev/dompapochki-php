<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Models\User;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Modules\IZColShower;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(User $user)
    {
        $this->middleware('auth');
        // set the model
        $this->model = new Repository($user);
    }

    public function index()
    {
        $grid = new IZColShower(
            trans('panel.user.header'),
            [
                'id' => trans('panel.id'),
                'name' => trans('panel.user.name'),
                'email' => trans('panel.user.email'),
            ],
            [
                'type' =>'collect',
                'items' => $this->model->all(),
            ],
            [
                'show' => 'user-show',
                'edit' => 'user-edit',
                'destroy' => 'user-destroy',
            ]
        );

        $grid->setHeaderActions([
            [
                'routers' => ['new' => 'user-create'],
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
            'item' => new User(),
            'route' => route('user-store')
        ];
        return view('forms.form-user', $data);
    }

    public function store(CreateUserRequest $request)
    {
        $this->validate($request, $request->rules());

        $model              =   $request->only($this->model->getModel()->fillable);

        // create record and pass in only fields that are fillable
        $model['password'] = bcrypt($model['password']);

        $this->model->create($model);

        return redirect(route('users'));
    }

    public function show($id)
    {
        $item = $this->model->show($id);
        $show = new IZColShower(
            $item->name,
            [
                'id' => trans('panel.id'),
                'name' => trans('panel.user.name'),
                'email' => trans('panel.user.email'),
            ],
            [
                'type' =>'item',
                'item' => $item,
            ],
            [
                'edit' => 'user-edit',
                'destroy' => 'user-destroy',
            ]
        );

        $show->description = trans('panel.user.description');
        $show->setBreadcrumbs([
            [
                'text' => trans('panel.user.header'),
                'link' => route('users')
            ],
            $item->name
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
            'route' => route('user-update', ['id' => $id])
        ];
        return view('forms.form-user', $data);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $this->validate($request, $request->rules());

        $model              =   $request->only($this->model->getModel()->fillable);

        if(!empty($model['password']))
        {
            $model['password'] = bcrypt($model['password']);
        }

        // update model and only pass in the fillable fields
        $this->model->update($model, $id);

        return redirect(route('user-show', $this->model->show($id)));
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $count = $this->model->delete($id);
        if($count > 0)
        {
            return response()->json(route('users'), 200);
        }
        else
        {
            return response()->json('error', 400);
        }
    }
}
