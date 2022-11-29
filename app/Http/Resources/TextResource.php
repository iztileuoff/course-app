<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TextResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'lesson_id' => $this->lesson->id,
            'text_id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
