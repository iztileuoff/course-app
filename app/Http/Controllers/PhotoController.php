<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Http\Resources\PhotoCollection;
use Illuminate\Http\Request;
use App\Helpers\StorageHelper;
use App\Http\Resources\PhotoResource;

class PhotoController extends Controller
{
    private $storage;

    public function __construct(Request $request)
    {
        $this->storage = new StorageHelper('file', $request->file('file'));
    }

    public function index(Request $request)
    {
        $query = Photo::query();
        
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
        
        return new PhotoCollection($result);
    }

    public function store(StorePhotoRequest $request)
    {
        $request->validated();

        $fileName = $this->storage->model(new Photo())->image()->saveImage('/public/photos');

        Photo::create([
            'lesson_id' => $request->input('lesson_id'),
            'file' => $fileName,
        ]);

        return response(['message' => 'Photo created successfully'], 201);
    }

    public function show($id)
    {
        $photo = Photo::where('id', $id)->get();
        
        return PhotoResource::collection($photo);
    }

    public function update(UpdatePhotoRequest $request, $id)
    {
        $request->validated();

        $data = [
            'lesson_id' => $request->input('lesson_id'),
        ];

        $data['file'] = $this->storage->model(Photo::find($id))->image()->saveImage('/public/photos');

        Photo::where('id', $id)->update($data);

        return response(['message' => 'Photo updated successfully'], 200);
    }

    public function destroy($id)
    {
        $this->storage->model(Photo::find($id))->destroyImage('/public/photos');
        Photo::where('id', $id)->delete();
        return response(['message' => 'Photo deleted successfully'], 200);
    }
}
