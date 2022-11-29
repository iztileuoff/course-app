<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DragdropResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'lesson_id' => $this->lesson->id,
            'dragdrop_id' => $this->id,
            'drag' => $this->drag,
            'drop' => $this->drop,
        ];
    }
}
