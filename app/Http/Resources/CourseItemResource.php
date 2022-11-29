<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'course_id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
        ];
    }
}
