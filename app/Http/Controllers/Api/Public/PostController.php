<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'category')->latest()->paginate(10);

        //return with Api Resource
        return new PostResource(true, 'List Data Posts', $posts);
    }

    public function show($slug)
    {
        $post = Post::with('user', 'category')->where('slug', $slug)->first();

        if ($post) {
            //return with Api Resource
            return new PostResource(true, 'Detail Data Post', $post);
        }

        //return with Api Resource
        return new PostResource(false, 'Detail Data Post Tidak Ditemukan!', null);
    }

    public function homePage()
    {
        $posts = Post::with('user', 'category')->latest()->take(6)->get();

        //return with Api Resource
        return new PostResource(true, 'List Data Post HomePage', $posts);
    }
}
