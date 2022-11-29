<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LessonCollection extends ResourceCollection
{
    public $collects = LessonItemResource::class;

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
