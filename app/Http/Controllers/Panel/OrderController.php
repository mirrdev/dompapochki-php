<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
//use App\Http\Requests\Order\CreateOrderRequest;
//use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Models\Order;
use App\Modules\IZColShower;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct(Order $order)
    {
        $this->middleware('auth');
        // set the model
        $this->model = new Repository($order);
    }

    public function index()
    {
        $grid = new IZColShower(
            trans('panel.order.header'),
            [
                'id' => trans('panel.id'),
                'phone' => trans('panel.order.fields.phone'),
                'cart' => trans('panel.order.fields.created_at'),
                'created_at' => trans('panel.created_at'),
            ],
            [
                'type' =>'collect',
                'items' => $this->model->last(300),
            ],
            [
                'show' => 'order-show',
                'destroy' => 'order-destroy',
            ]
        );

        $grid->setHeaderActions([
            [
                'routers' => [],
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
    public function archive()
    {
        $grid = new IZColShower(
            trans('panel.order.header'),
            [
                'id' => trans('panel.id'),
                'phone' => trans('panel.order.fields.phone'),
                'cart' => trans('panel.order.fields.created_at'),
                'created_at' => trans('panel.created_at'),
            ],
            [
                'type' =>'collect',
                'items' => $this->model->all(),
            ],
            [
                'show' => 'order-show',
                'destroy' => 'order-destroy',
            ]
        );

        $grid->setHeaderActions([
            [
                'routers' => [],
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

//    public function create()
//    {
//        $data = [
//            'title' => trans('panel.title'),
//            'item' => new Order(),
//            'seo' => new SeoMeta(),
//            'route' => route('order-store')
//        ];
//        return view('forms.form-order', $data);
//    }
//
//    public function store(CreateOrderRequest $request)
//    {
//        $this->validate($request, $request->rules());
//
//        $model              =   $request->only($this->model->getModel()->fillable);
//        $model['user_id']   =   Auth::user()->getAuthIdentifier();
//        $model['seo_id']    =   SeoMeta::create($request->only('seo'));
//        $model['slug']      =   Str::slug($model['title']);
//
//        // create record and pass in only fields that are fillable
//        $this->model->create($model);
//
//        return redirect(route('orders'));
//    }

    public function show($id)
    {
        $item = $this->model->show($id);

// dd($item);

        $show = new IZColShower(
            $item->id,
            [
                'id' => trans('panel.id'),
                'name' => trans('panel.order.fields.name'),
                'phone' => trans('panel.order.fields.phone'),
                'cart' => trans('panel.order.fields.cart'),
                'message' => trans('panel.order.fields.message'),
                'created_at' => trans('panel.created_at'),
                'delivery_info' => trans('panel.order.fields.delivery_info'),
            ],
            [
                'type' =>'item',
                'item' => $item,
            ],
            [
                'destroy' => 'order-destroy',
            ]
        );

        $show->description = $item->address;
        $show->setBreadcrumbs([
            [
                'text' => trans('panel.order.header'),
                'link' => route('orders')
            ],
            $item->title
        ]);

        $data = ['content' => [
            $show
        ]];

        return view('grid.show', $data);
    }

//    public function edit($id)
//    {
//        $item = $this->model->show($id);
//        $data = [
//            'title' => trans('panel.title'),
//            'item' => $item,
//            'seo' => SeoMeta::find($item->seo->id),
//            'route' => route('order-update', ['id' => $id])
//        ];
//        return view('forms.form-order', $data);
//    }
//
//    public function update(UpdateOrderRequest $request, $id)
//    {
//        $this->validate($request, $request->rules());
//        $item = $this->model->show($id);
//
//        $model              =   $request->only($this->model->getModel()->fillable);
//        $model['user_id']   =   Auth::user()->getAuthIdentifier();
//        $model['seo_id']    =   SeoMeta::edit($request->only('seo'), $item->seo->id);
//        $model['slug']      =   Str::slug($model['title']);
//
//        // update model and only pass in the fillable fields
//        $this->model->update($request->only($this->model->getModel()->fillable), $id);
//
//        return redirect(route('order-show', $this->model->show($id)));
//    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $count = $this->model->delete($id);
        if($count > 0)
        {
            return response()->json(route('orders'), 200);
        }
        else
        {
            return response()->json('error', 400);
        }
    }
}
