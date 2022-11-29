<?php

namespace App\Http\Controllers;

use App\Models\Text;
use App\Http\Requests\StoreTextRequest;
use App\Http\Requests\UpdateTextRequest;
use App\Http\Resources\TextCollection;
use Illuminate\Http\Request;
use App\Http\Resources\TextResource;

class TextController extends Controller
{
    public function index(Request $request)
    {
        $query = Text::query();
        
        if($title = $request->input('title')){
            $query->whereRaw("title LIKE '%". $title . "%'");
        }

        if($description = $request->input('description')){
            $query->whereRaw("description LIKE '%". $description . "%'");
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
        
        return new TextCollection($result);
    }

    public function store(StoreTextRequest $request)
    {
        $request->validated();

        Text::create([
            'lesson_id' => $request->input('lesson_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return response(['message' => 'Text created successfully'], 201);
    }

    public function show($id)
    {
        $text = Text::where('id', $id)->get();
        return TextResource::collection($text);
    }

    public function update(UpdateTextRequest $request, $id)
    {
        $request->validated();

        $data = [
            'lesson_id' => $request->input('lesson_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ];

        Text::where('id', $id)->update($data);

        return response(['message' => 'Text updated successfully'], 200);
    }

    public function destroy($id)
    {
        Text::where('id', $id)->delete();
        return response(['message' => 'Text deleted successfully'], 200);
    }
}