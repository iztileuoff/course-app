<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseCollection;
use Illuminate\Http\Request;
use App\Helpers\StorageHelper;
use App\Http\Resources\CourseResource;

class CourseController extends Controller
{
    private $storage;

    public function __construct(Request $request)
    {
        $this->storage = new StorageHelper('image', $request->file('image'));
    }

    public function index(Request $request)
    {
        $query = Course::query();
        
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
        
        return new CourseCollection($result);
    }

    public function store(StoreCourseRequest $request)
    {
        $request->validated();

        $imageName = $this->storage->model(new Course())->image()->saveImage('/public/images');

        Course::create([
            'title' => $request->input('title'),
            'image' => $imageName,
        ]);

        return response(['message' => 'Course created successfully'], 201);
    }

    public function show($id)
    {
        $course = Course::where('id', $id)->get();
        
        return CourseResource::collection($course);
    }

    public function update(UpdateCourseRequest $request, $id)
    {
        $request->validated();

        $data = [
            'title' => $request->input('title'),
        ];

        $data['image'] = $this->storage->model(Course::find($id))->image()->saveImage('/public/images');

        Course::where('id', $id)->update($data);

        return response(['message' => 'Course updated successfully'], 200);
    }

    public function destroy($id)
    {
        $this->storage->model(Course::find($id))->destroyImage('/public/images');
        Course::where('id', $id)->delete();
        return response(['message' => 'Course deleted successfully'], 200);
    }
}
