<?php

namespace App\Http\Requests;

use App\Models\SettingsDinamici;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySettingsDinamiciRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('settings_dinamici_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:settings_dinamicis,id',
        ];
    }
}
