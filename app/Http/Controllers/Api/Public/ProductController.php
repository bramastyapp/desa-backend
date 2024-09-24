<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(9);

        //return with Api Resource
        return new ProductResource(true, 'List Data Products', $products);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();

        if ($product) {
            //return with Api Resource
            return new ProductResource(true, 'Detail Data Product', $product);
        }

        //return with Api Resource
        return new ProductResource(false, 'Detail Data Product Tidak Ditemukan!', null);
    }

    public function homePage()
    {
        $products = Product::latest()->take(6)->get();

        //return with Api Resource
        return new ProductResource(true, 'List Data Products HomePage', $products);
    }
}
