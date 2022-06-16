<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Page\CreatePageRequest;
use App\Http\Requests\Page\UpdatePageRequest;
use App\Http\Models\Page;
use App\Http\Models\SeoMeta;
use App\Modules\IZColShower;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PageController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Page $page)
    {
        $this->middleware('auth');
        // set the model
        $this->model = new Repository($page);
    }

    public function index()
    {
        $grid = new IZColShower(
            trans('panel.pages.header'),
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
                'show' => 'page-show',
                'edit' => 'page-edit',
                'destroy' => 'page-destroy',
            ]
        );

        $grid->setHeaderActions([
            [
                'routers' => ['new' => 'page-create'],
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
            'item' => new Page(),
            'seo' => new SeoMeta(),
            'route' => route('page-store')
        ];
        return view('forms.form-page', $data);
    }

    public function store(CreatePageRequest $request)
    {
        $this->validate($request, $request->rules());

        $model              =   $request->only($this->model->getModel()->fillable);
        $model['user_id']   =   Auth::user()->getAuthIdentifier();
        $seo = $request->only('seo');

        if(empty($seo['title'])){
            $seo['seo']['title'] = $model['title'];
        }
        if(empty($seo['description'])){
            $seo['seo']['description'] = $model['title'];
        }

        $model['seo_id']    =   SeoMeta::create($seo);
        $model['slug']      =   (!isset($model['slug']) || empty($model['slug']) || is_null($model['slug'])) ? Str::slug($model['title']) : $model['slug'];

        // create record and pass in only fields that are fillable
        $this->model->create($model);

        return redirect(route('pages'));
    }

    public function show($id)
    {
        $item = $this->model->show($id);
        $show = new IZColShower(
            $item->title,
            [
                'id' => trans('panel.id'),
                'title' => trans('panel.pages.title'),
                'text' => trans('panel.pages.text'),
                'status' => trans('panel.pages.status.title'),
            ],
            [
                'type' =>'item',
                'item' => $item,
            ],
            [
                'edit' => 'page-edit',
                'destroy' => 'page-destroy',
            ]
        );

        $show->description = trans('panel.pages.description');
        $show->setBreadcrumbs([
            [
                'text' => trans('panel.pages.header'),
                'link' => route('pages')
            ],
            $item->title
        ]);

        $seo = new IZColShower(
            trans('panel.seo.header'),
            [
                'title' => trans('panel.seo.title'),
                'description' => trans('panel.seo.description'),
            ],
            [
                'type' =>'item',
                'item' => $item->seo,
            ]
        );

        $data = ['content' => [
            $show,
            $seo
        ]];

        return view('grid.show', $data);
    }

    public function edit($id)
    {
        $item = $this->model->show($id);
        $data = [
            'title' => trans('panel.title'),
            'item' => $item,
            'seo' => SeoMeta::find($item->seo->id),
            'route' => route('page-update', ['id' => $id])
        ];
        return view('forms.form-page', $data);
    }

    public function update(UpdatePageRequest $request, $id)
    {
        $this->validate($request, $request->rules());
        $item = $this->model->show($id);

        $model              =   $request->only($this->model->getModel()->fillable);
        $model['user_id']   =   Auth::user()->getAuthIdentifier();
        $model['seo_id']    =   SeoMeta::edit($request->only('seo'), $item->seo->id);
        $model['slug']      =   (!isset($model['slug']) || empty($model['slug']) || is_null($model['slug'])) ? Str::slug($model['title']) : $model['slug'];

        // update model and only pass in the fillable fields
        $this->model->update($request->only($this->model->getModel()->fillable), $id);

        return redirect(route('page-show', $this->model->show($id)));
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $seo = $this->model->deleteRelated('seo', $this->model->seo_id);
        $count = $this->model->delete($id);
        if($count > 0)
        {
            return response()->json(route('pages'), 200);
        }
        else
        {
            return response()->json('error', 400);
        }
    }
}
