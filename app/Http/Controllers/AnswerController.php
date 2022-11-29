<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Http\Resources\AnswerCollection;
use Illuminate\Http\Request;
use App\Http\Resources\AnswerResource;

class AnswerController extends Controller
{
    public function index(Request $request)
    {
        $query = Answer::query();
        
        if($answer = $request->input('answer')){
            $query->whereRaw("answer LIKE '%". $answer . "%'");
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
        
        return new AnswerCollection($result);
    }

    public function store(StoreAnswerRequest $request)
    {
        $request->validated();

        Answer::create([
            'test_id' => $request->input('test_id'),
            'answer' => $request->input('answer'),
            'true' => $request->input('true'),
        ]);

        return response(['message' => 'Answer created successfully'], 201);
    }

    public function show($id)
    {
        $answer = Answer::where('id', $id)->get();
        return AnswerResource::collection($answer);
    }

    public function update(UpdateAnswerRequest $request, $id)
    {
        $request->validated();

        $data = [
            'test_id' => $request->input('test_id'),
            'answer' => $request->input('answer'),
            'true' => $request->input('true'),
        ];

        Answer::where('id', $id)->update($data);

        return response(['message' => 'Answer updated successfully'], 200);
    }

    public function destroy($id)
    {
        Answer::where('id', $id)->delete();
        return response(['message' => 'Answer deleted successfully'], 200);
    }
}
