<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;
use App\Http\Resources\RatingCollection;
use Illuminate\Http\Request;
use App\Http\Resources\RatingResource;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        $query = Rating::query();
        
        if($mark = $request->input('mark')){
            $query->whereRaw("mark LIKE '%". $mark . "%'");
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
        
        return new RatingCollection($result);
    }

    public function store(StoreRatingRequest $request)
    {
        $request->validated();

        Rating::create([
            'lesson_id' => $request->input('lesson_id'),
            'user_id' => $request->input('title'),
            'mark' => $request->input('mark'),
        ]);

        return response(['message' => 'Rating created successfully'], 201);
    }

    public function show($id)
    {
        $rating = Rating::where('id', $id)->get();
        return RatingResource::collection($rating);
    }

    public function update(UpdateRatingRequest $request, $id)
    {
        $request->validated();

        $data = [
            'lesson_id' => $request->input('lesson_id'),
            'user_id' => $request->input('title'),
            'mark' => $request->input('mark'),
        ];

        Rating::where('id', $id)->update($data);

        return response(['message' => 'Rating updated successfully'], 200);
    }

    public function destroy($id)
    {
        Rating::where('id', $id)->delete();
        return response(['message' => 'Rating deleted successfully'], 200);
    }
}
