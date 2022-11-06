<?php

namespace Bws\Media\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

/**
 * @mixin MediaFile
 */
class FileResource extends JsonResource
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
            'basename'   => File::basename($this->url),
            'url'        => $this->url,
            'full_url'   => bws_media()->url($this->url),
            'type'       => $this->type,
            'icon'       => $this->icon,
            'thumb'      => $this->type == 'image' ? bws_media()->getImageUrl($this->url, 'thumb') : null,
            'size'       => $this->human_size,
            'mime_type'  => $this->mime_type,
            'created_at' => bws_helper()->formatDate($this->created_at, 'Y-m-d H:i:s'),
            'updated_at' => bws_helper()->formatDate($this->updated_at, 'Y-m-d H:i:s'),
            'options'    => $this->options,
            'folder_id'  => $this->folder_id,
        ];
    }
}
