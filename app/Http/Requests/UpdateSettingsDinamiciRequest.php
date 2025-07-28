<?php

namespace App\Http\Requests;

use App\Models\SettingsDinamici;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSettingsDinamiciRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('settings_dinamici_edit');
    }

    public function rules()
    {
        return [
            'progressivo' => [
                'string',
                'required',
            ],
        ];
    }
}
