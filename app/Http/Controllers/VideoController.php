<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Http\Resources\VideoCollection;
use Illuminate\Http\Request;
use App\Helpers\StorageHelper;
use App\Http\Resources\VideoResource;

class VideoController extends Controller
{
    private $storage;

    public function __construct(Request $request)
    {
        $this->storage = new StorageHelper('file', $request->file('file'));
    }

    public function index(Request $request)
    {
        $query = Video::query();
        
        if($lesson_id = $request->input('lesson_id')){
            $query->where("lesson_id", $lesson_id);
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
        
        return new VideoCollection($result);
    }

    public function store(StoreVideoRequest $request)
    {
        $request->validated();

        $fileName = $this->storage->model(new Video())->image()->saveImage('/public/videos');

        Video::create([
            'lesson_id' => $request->input('lesson_id'),
            'file' => $fileName,
        ]);

        return response(['message' => 'Video created successfully'], 201);
    }

    public function show($id)
    {
        $video = Video::where('id', $id)->get();
        
        return VideoResource::collection($video);
    }

    public function update(UpdateVideoRequest $request, $id)
    {
        $request->validated();

        $data = [
            'lesson_id' => $request->input('lesson_id'),
        ];

        $data['file'] = $this->storage->model(Video::find($id))->image()->saveImage('/public/videos');

        Video::where('id', $id)->update($data);

        return response(['message' => 'Video updated successfully'], 200);
    }

    public function destroy($id)
    {
        $this->storage->model(Video::find($id))->destroyImage('/public/videos');
        Video::where('id', $id)->delete();
        return response(['message' => 'Video deleted successfully'], 200);
    }
}
