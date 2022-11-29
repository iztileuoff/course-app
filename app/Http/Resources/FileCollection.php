<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FileCollection extends ResourceCollection
{
    public $collects = FileItemResource::class;

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
