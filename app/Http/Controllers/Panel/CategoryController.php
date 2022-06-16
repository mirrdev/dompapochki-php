<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Models\Category;
use App\Http\Models\SeoMeta;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Modules\IZColShower;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Image;

class CategoryController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Category $category)
    {
        $this->middleware('auth');
        // set the model
        $this->model = new Repository($category);
    }

    public function index()
    {
        $grid = new IZColShower(
            trans('panel.category.header'),
            [
                'id' => trans('panel.id'),
                'title' => trans('panel.category.fields.title'),
                'slug' => trans('panel.slug'),
            ],
            [
                'type' =>'collect',
                'items' => $this->model->all(),
            ],
            [
                'show' => 'category-show',
                'edit' => 'category-edit',
                'destroy' => 'category-destroy',
            ]
        );

        $grid->setHeaderActions([
            [
                'routers' => ['new' => 'category-create'],
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
            'item' => new Category(),
            'seo' => new SeoMeta(),
            'route' => route('category-store')
        ];
        return view('forms.form-category', $data);
    }

    public function store(CreateCategoryRequest $request)
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

//        $filepathNew = $model->filepath;
//
//        Image::make($model->filepath)->resize(700, 500)->insert($filepathNew);

        return redirect(route('categories'));
    }

    public function show($id)
    {
        $item = $this->model->show($id);

        $item->parent = (!is_null($item->parent_id)) ? Category::find($item->parent_id)->title : '-';
        $show = new IZColShower(
            $item->title,
            [
                'id' => trans('panel.id'),
                'title' => trans('panel.category.fields.title'),
                'text' => trans('panel.category.fields.text'),
                'slug' => trans('panel.category.fields.slug'),
                'parent' => trans('panel.category.fields.parent'),
            ],
            [
                'type' =>'item',
                'item' => $item,
            ],
            [
                'edit' => 'category-edit',
                'destroy' => 'category-destroy',
            ]
        );

        $show->description = trans('panel.category.description');
        $show->setBreadcrumbs([
            [
                'text' => trans('panel.category.header'),
                'link' => route('categories')
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

        $data = [
            'content' => [
                $show,
                $seo
            ],
        ];

        return view('grid.show', $data);
    }

    public function edit($id)
    {
        $item = $this->model->show($id);

        $data = [
            'title' => trans('panel.title'),
            'item' => $item,
            'seo' => SeoMeta::find($item->seo->id),
            'route' => route('category-update', ['id' => $id]),
        ];
        return view('forms.form-category', $data);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $this->validate($request, $request->rules());
        $item = $this->model->show($id);

        $model              =   $request->only($this->model->getModel()->fillable);
        $model['user_id']   =   Auth::user()->getAuthIdentifier();
        $model['seo_id']    =   SeoMeta::edit($request->only('seo'), $item->seo->id);
        $model['slug']      =   (!isset($model['slug']) || empty($model['slug']) || is_null($model['slug'])) ? Str::slug($model['title']) : $model['slug'];

        // update model and only pass in the fillable fields
        $this->model->update($model, $id);

        return redirect(route('category-show', $this->model->show($id)));
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $seo = $this->model->deleteRelated('\App\Http\Models\SeoMeta', $id, 'seo_id');
        $count = $this->model->delete($id);
        if($count > 0)
        {
            return response()->json(route('categories'), 200);
        }
        else
        {
            return response()->json('error', 400);
        }
    }
}
