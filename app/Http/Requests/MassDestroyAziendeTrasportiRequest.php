<?php

namespace App\Http\Requests;

use App\Models\AziendeTrasporti;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAziendeTrasportiRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('aziende_trasporti_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:aziende_trasportis,id',
        ];
    }
}
