<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DragdropItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'lesson_id' => $this->lesson->id,
            'dragdrop_id' => $this->id,
            'drag' => $this->drag,
            'drop' => $this->drop,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
        ];
    }
}
