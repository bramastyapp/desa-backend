<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        //get categories
        $categories = Category::when(request()->search, function ($categories) {
            $categories = $categories->where('name', 'like', '%' . request()->search . '%');
        })->latest()->paginate(5);

        //append query string to pagination links
        $categories->appends(['search' => request()->search]);

        //return with Api Resource
        return new CategoryResource(true, 'List Data Categories', $categories);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|unique:categories',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create category
        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ]);

        if ($category) {
            //return success with Api Resource
            return new CategoryResource(true, 'Data Category Berhasil Disimpan!', $category);
        }

        //return failed with Api Resource
        return new CategoryResource(false, 'Data Category Gagal Disimpan!', null);
    }

    public function show($id)
    {
        $category = Category::whereId($id)->first();

        if ($category) {
            //return success with Api Resource
            return new CategoryResource(true, 'Detail Data Category!', $category);
        }

        //return failed with Api Resource
        return new CategoryResource(false, 'Detail Data Category Tidak DItemukan!', null);
    }

    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|unique:categories,name,' . $category->id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //update category without image
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ]);

        if ($category) {
            //return success with Api Resource
            return new CategoryResource(true, 'Data Category Berhasil Diupdate!', $category);
        }

        //return failed with Api Resource
        return new CategoryResource(false, 'Data Category Gagal Diupdate!', null);
    }

    public function destroy(Category $category)
    {
        if ($category->delete()) {
            //return success with Api Resource
            return new CategoryResource(true, 'Data Category Berhasil Dihapus!', null);
        }

        //return failed with Api Resource
        return new CategoryResource(false, 'Data Category Gagal Dihapus!', null);
    }

    public function all()
    {
        //get categories
        $categories = Category::latest()->get();

        //return with Api Resource
        return new CategoryResource(true, 'List Data Categories', $categories);
    }
}
