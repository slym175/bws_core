<?php

namespace Bws\Media\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FolderResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'created_at' => bws_helper()->formatDate($this->created_at, 'Y-m-d H:i:s'),
            'updated_at' => bws_helper()->formatDate($this->updated_at, 'Y-m-d H:i:s'),
        ];
    }
}
