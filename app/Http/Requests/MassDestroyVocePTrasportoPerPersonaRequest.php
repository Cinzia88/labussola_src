<?php

namespace App\Http\Requests;

use App\Models\VocePTrasportoPerPersona;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyVocePTrasportoPerPersonaRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('voce_p_trasporto_per_persona_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:voce_p_trasporto_per_personas,id',
        ];
    }
}
