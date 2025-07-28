<?php

namespace App\Http\Requests;

use App\Models\VocePTrasportoPerPersona;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateVocePTrasportoPerPersonaRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('voce_p_trasporto_per_persona_edit');
    }

    public function rules()
    {
        return [
            'trasporto_id' => [
                'required',
                'integer',
            ],
            'prezzo' => [
                'required',
            ],
            'preventivo_id' => [
                'required',
                'integer',
            ],
            'tipologia' => [
                'required',
            ],
        ];
    }
}
