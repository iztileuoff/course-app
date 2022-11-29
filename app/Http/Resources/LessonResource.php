<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'lesson_id' => $this->id,
            'category_id' => $this->category->id,
            'category_title' => $this->category->title,
            'title' => $this->title,
            'files' => FileResource::collection($this->files),
            'videos' => VideoResource::collection($this->videos),
            'texts' => TextResource::collection($this->texts),
            'photos' => PhotoResource::collection($this->photos),
            'tests' => TestResource::collection($this->tests),
            'dragdrops' => DragdropResource::collection($this->dragdrops),
            'ratings' => $this->ratings,
        ];
    }
}
