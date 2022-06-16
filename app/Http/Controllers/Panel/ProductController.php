<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Models\Option;
use App\Http\Models\Permission;
use App\Http\Models\Product;
use App\Http\Models\ProductPermissions;
use App\Http\Models\SeoMeta;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Modules\IZColShower;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Product $product)
    {
        $this->middleware('auth');
        // set the model
        $this->model = new Repository($product);
    }

    public function index()
    {
        $grid = new IZColShower(
            trans('panel.product.header'),
            [
                'id' => trans('panel.id'),
                'title' => trans('panel.product.fields.title'),
                'slug' => trans('panel.product.fields.slug'),
            ],
            [
                'type' =>'collect',
                'items' => $this->model->all(),
            ],
            [
                'show' => 'product-show',
                'edit' => 'product-edit',
                'destroy' => 'product-destroy',
            ]
        );

        $grid->setHeaderActions([
            [
                'routers' => ['new' => 'product-create'],
                'id' => null
            ]
        ]);

        $data = ['data' => $grid];

        return view('grid.panel', $data);
    }

    public function create()
    {
        $data = [
            'title' => trans('panel.title'),
            'item' => new Product(),
            'seo' => new SeoMeta(),
            'route' => route('product-store')
        ];
        return view('forms.form-product', $data);
    }

    public function store(CreateProductRequest $request)
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
        
        $model = $this->model->create($model);

        return redirect(route('products'));
    }

    public function show($id)
    {
        $item = $this->model->show($id);
        $show = new IZColShower(
            $item->title,
            [
                'id' => trans('panel.id'),
                'title' => trans('panel.product.fields.title'),
                'description' => trans('panel.product.fields.description'),
                'detail1' => trans('panel.product.fields.detail1'),
                'price1' => trans('panel.product.fields.price1'),
                'detail2' => trans('panel.product.fields.detail2'),
                'price2' => trans('panel.product.fields.price2'),
                'detail3' => trans('panel.product.fields.detail3'),
                'price3' => trans('panel.product.fields.price3'),
                'label' => trans('panel.product.fields.label.title'),
                'text' => trans('panel.product.fields.text'),
                'slug' => trans('panel.product.fields.slug'),
            ],
            [
                'type' =>'item',
                'item' => $item,
            ],
            [
                'edit' => 'product-edit',
                'destroy' => 'product-destroy',
            ]
        );

        $show->description = trans('panel.product.description');
        $show->setBreadcrumbs([
            [
                'text' => trans('panel.product.header'),
                'link' => route('products')
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
        $seo = SeoMeta::find($item->seo_id);
        if(!isset($seo->id) || is_null($seo)){
            $item->seo_id = SeoMeta::create(['seo' => ['title' => $item->title, 'description' => $item->title]]);
            $item->save();
        }

        $data = [
            'title' => trans('panel.title'),
            'item' => $item,
            'route' => route('product-update', ['id' => $id]),
            'seo' => SeoMeta::find($item->seo->id),
        ];

        return view('forms.form-product', $data);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $this->validate($request, $request->rules());
        $item = $this->model->show($id);

        $model              =   $request->only($this->model->getModel()->fillable);
        $model['user_id']   =   Auth::user()->getAuthIdentifier();
        $model['seo_id']    =   SeoMeta::edit($request->only('seo'), $item->seo->id);
        $model['slug']      =   (!isset($model['slug']) || empty($model['slug']) || is_null($model['slug'])) ? Str::slug($model['title']) : $model['slug'];

        // update model and only pass in the fillable fields
        $this->model->update($model, $id);

        return redirect(route('product-show', $this->model->show($id)));
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $count = $this->model->delete($id);

        if($count > 0)
        {
            return response()->json(route('products'), 200);
        }
        else
        {
            return response()->json('error', 400);
        }
    }

    public function export()
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="products.csv"');
        $data = [];

        $products = Product::getAllShow();
        foreach ($products as $product) {
            for($i = 1; $i < 4; $i++)
            {
                $name = "name$i";
                $detail = "detail$i";
                $price = "price$i";
                if (!is_null($product->$name)) {
                    $item = "{$i}00{$product->id};";
                    $item .= "{$product->title};";
                    $item .= "{$product->filepath};";
                    $item .= "{$product->description};";
                    $item .= "{$product->$name};";
                    $item .= "{$product->$detail};";
                    $item .= "{$product->$price}";
                    $data[] = $item;
                }
            }
        }

        $fp = fopen('php://output', 'wb');
        foreach ( $data as $line ) {
            $val = explode(";", $line);
            fputcsv($fp, $val);
        }
        fclose($fp);
    }
}
