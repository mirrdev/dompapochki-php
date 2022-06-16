<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Nav\CreateNavRequest;
use App\Http\Requests\Nav\UpdateNavRequest;
use App\Http\Models\Nav;
use App\Modules\IZColShower;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NavController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Nav $nav)
    {
        $this->middleware('auth');
        // set the model
        $this->model = new Repository($nav);
    }

    public function index()
    {
        $grid = new IZColShower(
            trans('panel.nav.header'),
            [
                'id' => trans('panel.id'),
                'title' => trans('panel.title'),
                'status' => trans('panel.status'),
            ],
            [
                'type' =>'collect',
                'items' => $this->model->all(),
            ],
            [
                'show' => 'nav-show',
                'edit' => 'nav-edit',
                'destroy' => 'nav-destroy',
            ]
        );

        $grid->setHeaderActions([
            [
                'routers' => ['new' => 'nav-create'],
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
            'item' => new Nav(),
            'route' => route('nav-store')
        ];
        return view('forms.form-nav', $data);
    }

    public function store(CreateNavRequest $request)
    {
        $this->validate($request, $request->rules());

        $model              =   $request->only($this->model->getModel()->fillable);
        $model['user_id']   =   Auth::user()->getAuthIdentifier();

        // create record and pass in only fields that are fillable
        $this->model->create($model);

        return redirect(route('navs'));
    }

    public function show($id)
    {
        $item = $this->model->show($id);
        $show = new IZColShower(
            $item->title,
            [
                'id' => trans('panel.id'),
                'title' => trans('panel.nav.title'),
                'url' => trans('panel.nav.url'),
                'status' => trans('panel.nav.status.title'),
            ],
            [
                'type' =>'item',
                'item' => $item,
            ],
            [
                'edit' => 'nav-edit',
                'destroy' => 'nav-destroy',
            ]
        );

        $show->description = trans('panel.nav.description');
        $show->setBreadcrumbs([
            [
                'text' => trans('panel.nav.header'),
                'link' => route('navs')
            ],
            $item->title
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
            'route' => route('nav-update', ['id' => $id])
        ];
        return view('forms.form-nav', $data);
    }

    public function update(UpdateNavRequest $request, $id)
    {
        $this->validate($request, $request->rules());

        $model              =   $request->only($this->model->getModel()->fillable);
        $model['user_id']   =   Auth::user()->getAuthIdentifier();

        // update model and only pass in the fillable fields
        $this->model->update($request->only($this->model->getModel()->fillable), $id);

        return redirect(route('nav-show', $this->model->show($id)));
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $count = $this->model->delete($id);
        if($count > 0)
        {
            return response()->json(route('navs'), 200);
        }
        else
        {
            return response()->json('error', 400);
        }
    }
}
