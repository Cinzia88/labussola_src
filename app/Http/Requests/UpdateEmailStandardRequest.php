<?php

namespace App\Http\Requests;

use App\Models\EmailStandard;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmailStandardRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('email_standard_edit');
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
