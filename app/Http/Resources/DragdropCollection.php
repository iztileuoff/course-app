<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DragdropCollection extends ResourceCollection
{
    public $collects = DragdropItemResource::class;

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
