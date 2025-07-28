<?php

namespace App\Http\Requests;

use App\Models\EmailStandard;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEmailStandardRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('email_standard_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:email_standards,id',
        ];
    }
}
