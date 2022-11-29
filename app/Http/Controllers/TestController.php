<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Http\Requests\StoreTestRequest;
use App\Http\Requests\UpdateTestRequest;
use App\Http\Resources\TestCollection;
use Illuminate\Http\Request;
use App\Http\Resources\TestResource;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $query = Test::query();
        
        if($question = $request->input('question')){
            $query->whereRaw("question LIKE '%". $question . "%'");
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
        
        return new TestCollection($result);
    }

    public function store(StoreTestRequest $request)
    {
        $request->validated();

        Test::create([
            'lesson_id' => $request->input('lesson_id'),
            'question' => $request->input('question'),
        ]);

        return response(['message' => 'Test created successfully'], 201);
    }

    public function show($id)
    {
        $test = Test::where('id', $id)->get();
        
        return TestResource::collection($test);
    }

    public function update(UpdateTestRequest $request, $id)
    {
        $request->validated();

        $data = [
            'lesson_id' => $request->input('lesson_id'),
            'question' => $request->input('question'),
        ];

        Test::where('id', $id)->update($data);

        return response(['message' => 'Test updated successfully'], 200);
    }

    public function destroy($id)
    {
        Test::where('id', $id)->delete();
        return response(['message' => 'Test deleted successfully'], 200);
    }
}
