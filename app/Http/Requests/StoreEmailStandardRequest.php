<?php

namespace App\Http\Requests;

use App\Models\EmailStandard;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmailStandardRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('email_standard_create');
    }

    public function rules()
    {
        return [
            'nome' => [
                'string',
                'required',
            ],
            'corpo_email' => [
                'required',
            ],
        ];
    }
}
