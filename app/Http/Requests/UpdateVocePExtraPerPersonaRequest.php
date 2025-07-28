<?php

namespace App\Http\Requests;

use App\Models\VocePExtraPerPersona;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateVocePExtraPerPersonaRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('voce_p_extra_per_persona_edit');
    }

    public function rules()
    {
        return [
            'servizio_extra_id' => [
                'required',
                'integer',
            ],
            'prezzo' => [
                'required',
            ],
            'quantita' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
