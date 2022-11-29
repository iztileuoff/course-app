<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();
        
        if($title = $request->input('title')){
            $query->whereRaw("title LIKE '%". $title . "%'");
        }
        
        if($start_date = $request->input('start_date')){
            $query->whereDate('created_at', '>=', $start_date);
        }

        if($end_date = $request->input('end_date')){
            $query->whereDate('created_at', '<=', $end_date);
        }

        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);

        $result = $query->paginate($limit, ['*'], 'page', $page);
        
        return new CategoryCollection($result);
    }

    public function store(StoreCategoryRequest $request)
    {
        $request->validated();

        Category::create([
            'course_id' => $request->input('course_id'),
            'title' => $request->input('title'),
        ]);

        return response(['message' => 'Category created successfully'], 201);
    }

    public function show($id)
    {
        $category = Category::where('id', $id)->get();
        
        return CategoryResource::collection($category);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $request->validated();

        $data = [
            'course_id' => $request->input('course_id'),
            'title' => $request->input('title'),
        ];

        Category::where('id', $id)->update($data);

        return response(['message' => 'Category updated successfully'], 200);
    }

    public function destroy($id)
    {
        Category::where('id', $id)->delete();
        return response(['message' => 'Category deleted successfully'], 200);
    }
}
