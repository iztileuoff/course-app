<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Http\Resources\LessonCollection;
use Illuminate\Http\Request;
use App\Http\Resources\LessonResource;

class LessonController extends Controller
{
    public function index(Request $request)
    {
        $query = Lesson::query();
        
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
        
        return new LessonCollection($result);
    }


    public function store(StoreLessonRequest $request)
    {
        $request->validated();

        Lesson::create([
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
        ]);

        return response(['message' => 'Lesson created successfully'], 201);
    }

    public function show($id)
    {
        $lesson = Lesson::where('id', $id)->get();
        
        return LessonResource::collection($lesson);
    }


    public function update(UpdateLessonRequest $request, $id)
    {
        $request->validated();

        $data = [
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
        ];

        Lesson::where('id', $id)->update($data);

        return response(['message' => 'Lesson updated successfully'], 200);
    }

    public function destroy($id)
    {
        Lesson::where('id', $id)->delete();
        return response(['message' => 'Lesson deleted successfully'], 200);
    }
}
