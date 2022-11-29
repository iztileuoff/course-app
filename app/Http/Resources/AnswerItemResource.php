<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'test_id' => $this->test->id,
            'answer_id' => $this->id,
            'answer' => $this->answer,
            'true' => $this->true,
        ];
    }
}
