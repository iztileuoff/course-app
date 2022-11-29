<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'category_id' => $this->id,
            'title' => $this->title,
            'course_title' => $this->course->title,
            'lessons' => LessonItemResource::collection($this->lessons),
        ];
    }
}
