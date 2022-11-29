<?php

namespace App\Http\Controllers;

use App\Models\Dragdrop;
use App\Http\Requests\StoreDragdropRequest;
use App\Http\Requests\UpdateDragdropRequest;
use App\Http\Resources\DragdropCollection;
use Illuminate\Http\Request;
use App\Http\Resources\DragdropResource;

class DragdropController extends Controller
{
    public function index(Request $request)
    {
        $query = Dragdrop::query();
        
        if($drag = $request->input('drag')){
            $query->whereRaw("drag LIKE '%". $drag . "%'");
        }

        if($drop = $request->input('drop')){
            $query->whereRaw("drop LIKE '%". $drop . "%'");
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
        
        return new DragdropCollection($result);
    }

    public function store(StoreDragdropRequest $request)
    {
        $request->validated();

        Dragdrop::create([
            'lesson_id' => $request->input('lesson_id'),
            'drag' => $request->input('drag'),
            'drop' => $request->input('drop'),
        ]);

        return response(['message' => 'Dragdrop created successfully'], 201);
    }

    public function show($id)
    {
        $dragdrop = Dragdrop::where('id', $id)->get();
        return DragdropResource::collection($dragdrop);
    }

    public function update(UpdateDragdropRequest $request, $id)
    {
        $request->validated();

        $data = [
            'lesson_id' => $request->input('lesson_id'),
            'drag' => $request->input('drag'),
            'drop' => $request->input('drop'),
        ];

        Dragdrop::where('id', $id)->update($data);

        return response(['message' => 'Dragdrop updated successfully'], 200);
    }

    public function destroy($id)
    {
        Dragdrop::where('id', $id)->delete();
        return response(['message' => 'Dragdrop deleted successfully'], 200);
    }
}
