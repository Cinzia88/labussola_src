<?php

namespace App\Http\Requests;

use App\Models\VocePTrasportoPerPersona;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVocePTrasportoPerPersonaRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('voce_p_trasporto_per_persona_create');
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
