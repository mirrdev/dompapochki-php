<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Models\Settings;
use App\Http\Requests\Setting\CreateSettingRequest;
use App\Http\Requests\Setting\UpdateSettingRequest;
use App\Modules\IZColShower;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Settings $settings)
    {
        $this->middleware('auth');
        // set the model
        $this->model = new Repository($settings);
    }

    public function index()
    {
        $grid = new IZColShower(
            trans('panel.settings.header'),
            [
                'id' => trans('panel.id'),
                'title' => trans('panel.title'),
                'key' => trans('panel.key'),
            ],
            [
                'type' =>'collect',
                'items' => $this->model->all(),
            ],
            [
                'show' => 'setting-show',
                'edit' => 'setting-edit',
                'destroy' => 'setting-destroy',
            ]
        );

        $grid->setHeaderActions([
            [
                'routers' => ['new' => 'setting-create'],
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
            'item' => new Settings(),
            'route' => route('setting-store')
        ];
        return view('forms.form-setting', $data);
    }

    public function store(CreateSettingRequest $request)
    {
        $this->validate($request, $request->rules());

        $model              =   $request->only($this->model->getModel()->fillable);
        $model['user_id']   =   Auth::user()->getAuthIdentifier();

        // create record and pass in only fields that are fillable
        $this->model->create($model);

        return redirect(route('settings'));
    }

    public function show($id)
    {
        $item = $this->model->show($id);
        $show = new IZColShower(
            $item->title,
            [
                'id' => trans('panel.id'),
                'title' => trans('panel.settings.title'),
                'key' => trans('panel.settings.key'),
            ],
            [
                'type' =>'item',
                'item' => $item,
            ],
            [
                'edit' => 'setting-edit',
                'destroy' => 'setting-destroy',
            ]
        );

        $show->description = trans('panel.settings.description');
        $show->setBreadcrumbs([
            [
                'text' => trans('panel.settings.header'),
                'link' => route('settings')
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
            'route' => route('setting-update', ['id' => $id])
        ];
        return view('forms.form-setting', $data);
    }

    public function update(UpdateSettingRequest $request, $id)
    {
        $this->validate($request, $request->rules());

        $model              =   $request->only($this->model->getModel()->fillable);
        $model['user_id']   =   Auth::user()->getAuthIdentifier();

        // update model and only pass in the fillable fields
        $this->model->update($request->only($this->model->getModel()->fillable), $id);

        return redirect(route('setting-show', $this->model->show($id)));
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $count = $this->model->delete($id);
        if($count > 0)
        {
            return response()->json(route('settings'), 200);
        }
        else
        {
            return response()->json('error', 400);
        }
    }
}
