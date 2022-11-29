<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'video_id' => $this->id,
            'url' => 'public/storage/videos/',
            'file' => $this->file
        ];
    }
}
