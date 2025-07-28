<?php

namespace App\Http\Requests;

use App\Models\VocePHotelPerPersona;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyVocePHotelPerPersonaRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('voce_p_hotel_per_persona_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:voce_p_hotel_per_personas,id',
        ];
    }
}
