<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'rating_id' => $this->id,
            'lesson_id' => $this->lesson->id,
            'user_id' => $this->user->id,
            'mark' => $this->mark,
        ];
    }
}
