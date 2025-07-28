<?php

namespace App\Http\Requests;

use App\Models\ServizioExtra;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreServizioExtraRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('servizio_extra_create');
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
