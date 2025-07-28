<?php

namespace App\Http\Requests;

use App\Models\ServizioExtra;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateServizioExtraRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('servizio_extra_edit');
    }

    public function rules()
    {
        return [
            'nome' => [
                'string',
                'required',
            ],
        ];
    }
}
