<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'course_id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'categories' => CategoryItemResource::collection($this->categories),
        ];
    }
}
