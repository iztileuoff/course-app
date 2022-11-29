<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PhotoCollection extends ResourceCollection
{
    public $collects = PhotoItemResource::class;

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
