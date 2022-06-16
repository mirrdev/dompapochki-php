<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Models\Product;

class ProductController extends Controller
{
    public function index($productSlug)
    {
        $product = Product::where([
            'slug' => $productSlug
        ])->first();
        $data = [
            'product' => $product,
            'seo' => $product->seo
        ];
        return view('site/product', $data);
    }
}
