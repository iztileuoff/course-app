<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TestCollection extends ResourceCollection
{
    public $collects = TestItemResource::class;

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
