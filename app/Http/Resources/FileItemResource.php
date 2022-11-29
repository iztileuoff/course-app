<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FileItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'lesson_id' => $this->lesson->id,
            'file_id' => $this->id,
            'url' => 'public/storage/files/',
            'file' => $this->file,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
        ];
    }
}
