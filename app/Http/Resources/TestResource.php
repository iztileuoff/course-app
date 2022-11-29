<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'lesson_id' => $this->lesson->id,
            'test_id' => $this->id,
            'question' => $this->question,
            'answers' => AnswerItemResource::collection($this->answers),
        ];
    }
}
