<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
    public $status;
    public $message;

    public function __construct($resource, $status = null, $message = null,)
    {
        parent::__construct($resource);
        $this->status =  $status;
        $this->message = $message;
    }

    public function toArray($request)
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => [
                'article' => $this->collection,
                'articleCount' => $this->count()
            ]
        ];
    }
}
