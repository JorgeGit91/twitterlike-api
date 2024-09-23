<?php

namespace Modules\Post\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'media_name' => $this->media_name,
            'media_content' => $this->media_content != null ? asset(Storage::url($this->media_content)) : null,
            'likes' => $this->likes->count(),
            'user' => $this->user
        ];
    }
}
