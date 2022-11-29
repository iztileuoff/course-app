<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TestItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'lesson_id' => $this->lesson->id,
            'test_id' => $this->id,
            'question' => $this->question,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
        ];
    }
}
