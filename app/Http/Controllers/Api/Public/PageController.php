<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::oldest()->get();

        //return with Api Resource
        return new PageResource(true, 'List Data Pages', $pages);
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->first();

        if ($page) {
            //return with Api Resource
            return new PageResource(true, 'Detail Data Page', $page);
        }

        //return with Api Resource
        return new PageResource(false, 'Detail Data Page Tidak Ditemukan!', null);
    }
}
