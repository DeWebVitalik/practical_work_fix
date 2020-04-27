<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Link as LinkModel;

class Link extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => $this->alias,
            'single_view' => $this->single_view === LinkModel::SINGLE_VIEW,
            'file_name' => $this->file->file_name
        ];
    }
}
