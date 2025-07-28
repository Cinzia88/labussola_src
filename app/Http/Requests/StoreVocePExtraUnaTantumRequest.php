<?php

namespace App\Http\Requests;

use App\Models\VocePExtraUnaTantum;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVocePExtraUnaTantumRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('voce_p_extra_una_tantum_create');
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
            'preventivo_id' => [
                'required',
                'integer',
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
