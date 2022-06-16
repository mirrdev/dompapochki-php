<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Models\Category;
use App\Http\Models\Product;

class CategoryController extends Controller
{
    public function index($categorySlug)
    {
        $category = Category::where([
            'slug' => $categorySlug
        ])->first();

        if (isset($category->id) && !(empty($category->id))) {
            $childs = Category::where([
                'parent_id' => $category->id
            ])->get();
            if (!is_null($childs) && count($childs) > 0) {
                $products = collect([]);
                foreach ($childs as $child) {
                    $products = $products->merge(Product::getAllThisCategory($child->id));
                }
            } else {
                $products = Product::getAllThisCategory($category->id);
            }
            return view('site/category', [
                'category' => $category,
                'products' => $products,
                'seo' => $category->seo
            ]);
        } else {
            return abort(404);
        }
    }
}