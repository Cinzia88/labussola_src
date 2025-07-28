<?php

namespace App\Http\Requests;

use App\Models\Scadenziario;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateScadenziarioRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('scadenziario_edit');
    }

    public function rules()
    {
        return [
            'nome' => [
                'string',
                'required',
            ],
            'data' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'preventivo_id' => [
                'required',
                'integer',
            ],
            'colore_eticchetta' => [
                'required',
            ],
        ];
    }
}
