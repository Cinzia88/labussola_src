<?php

namespace App\Http\Requests;

use App\Models\Trasporto;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTrasportoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('trasporto_edit');
    }

    public function rules()
    {
        return [
            'nome' => [
                'string',
                'required',
            ],
            'foto' => [
                'array',
            ],
        ];
    }
}
