<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'file_id' => $this->id,
            'url' => 'public/storage/files/',
            'file' => $this->file
        ];
    }
}
