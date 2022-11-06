<?php

namespace Bws\Media\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaFolderRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|regex:/^[\pL\s\ \_\-0-9]+$/u',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.regex' => trans('bws/media::media.name_invalid'),
        ];
    }
}
