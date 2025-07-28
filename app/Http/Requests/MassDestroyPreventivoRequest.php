<?php

namespace App\Http\Requests;

use App\Models\Preventivo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPreventivoRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('preventivo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:preventivos,id',
        ];
    }
}
