<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Models\Page;

class PageController extends Controller
{
    public function index($pageSlug)
    {
        $page = Page::where([
            'slug' => $pageSlug
        ])->first();
        $seo = isset($page->seo) ? $page->seo : '';

        $data = [
            'page' => $page,
            'seo' => $seo
        ];
        return view('site/page', $data);
    }
}
