<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Slide\CreateSlideRequest;
use App\Http\Requests\Slide\UpdateSlideRequest;
use App\Http\Models\Slide;
use App\Modules\IZColShower;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SlideController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Slide $slide)
    {
        $this->middleware('auth');
        // set the model
        $this->model = new Repository($slide);
    }

    public function index()
    {
        $grid = new IZColShower(
            trans('panel.slide.header'),
            [
                'id' => trans('panel.id'),
                'status' => trans('panel.status'),
            ],
            [
                'type' =>'collect',
                'items' => $this->model->all(),
            ],
            [
                'show' => 'slide-show',
                'edit' => 'slide-edit',
                'destroy' => 'slide-destroy',
            ]
        );

        $grid->setHeaderActions([
            [
                'routers' => ['new' => 'slide-create'],
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
            'item' => new Slide(),
            'route' => route('slide-store')
        ];
        return view('forms.form-slide', $data);
    }

    public function store(CreateSlideRequest $request)
    {
        $this->validate($request, $request->rules());

        $model              =   $request->only($this->model->getModel()->fillable);
        $model['user_id']   =   Auth::user()->getAuthIdentifier();

        // create record and pass in only fields that are fillable
        $this->model->create($model);

        return redirect(route('slides'));
    }

    public function show($id)
    {
        $item = $this->model->show($id);
        $show = new IZColShower(
            '',
            [
                'id' => trans('panel.id'),
                'filepath' => trans('panel.slide.fields.filepath'),
                'status' => trans('panel.slide.fields.status.title'),
            ],
            [
                'type' =>'item',
                'item' => $item,
            ],
            [
                'edit' => 'slide-edit',
                'destroy' => 'slide-destroy',
            ]
        );

        $show->description = trans('panel.slide.description');
        $show->setBreadcrumbs([
            [
                'text' => trans('panel.slide.header'),
                'link' => route('slides')
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
            'route' => route('slide-update', ['id' => $id])
        ];
        return view('forms.form-slide', $data);
    }

    public function update(UpdateSlideRequest $request, $id)
    {
        $this->validate($request, $request->rules());

        $model              =   $request->only($this->model->getModel()->fillable);
        $model['user_id']   =   Auth::user()->getAuthIdentifier();

        // update model and only pass in the fillable fields
        $this->model->update($request->only($this->model->getModel()->fillable), $id);

        return redirect(route('slide-show', $this->model->show($id)));
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $count = $this->model->delete($id);
        if($count > 0)
        {
            return response()->json(route('slides'), 200);
        }
        else
        {
            return response()->json('error', 400);
        }
    }
}
