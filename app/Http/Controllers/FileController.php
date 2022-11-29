<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Resources\FileCollection;
use Illuminate\Http\Request;
use App\Helpers\StorageHelper;
use App\Http\Resources\FileResource;

class FileController extends Controller
{
    private $storage;

    public function __construct(Request $request)
    {
        $this->storage = new StorageHelper('file', $request->file('file'));
    }

    public function index(Request $request)
    {
        $query = File::query();
        
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
        
        return new FileCollection($result);
    }

    public function store(StoreFileRequest $request)
    {
        $request->validated();

        $fileName = $this->storage->model(new File())->image()->saveImage('/public/files');

        File::create([
            'lesson_id' => $request->input('lesson_id'),
            'file' => $fileName,
        ]);

        return response(['message' => 'File created successfully'], 201);
    }

    public function show($id)
    {
        $file = File::where('id', $id)->get();
        
        return FileResource::collection($file);
    }

    public function update(UpdateFileRequest $request, $id)
    {
        $request->validated();

        $data = [
            'lesson_id' => $request->input('lesson_id'),
        ];

        $data['file'] = $this->storage->model(File::find($id))->image()->saveImage('/public/files');

        File::where('id', $id)->update($data);

        return response(['message' => 'File updated successfully'], 200);
    }

    public function destroy($id)
    {
        $this->storage->model(File::find($id))->destroyImage('/public/files');
        File::where('id', $id)->delete();
        return response(['message' => 'File deleted successfully'], 200);
    }
}
