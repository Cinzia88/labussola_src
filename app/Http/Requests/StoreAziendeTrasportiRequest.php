<?php

namespace App\Http\Requests;

use App\Models\AziendeTrasporti;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAziendeTrasportiRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('aziende_trasporti_create');
    }

    public function rules()
    {
        return [
            'nome' => [
                'string',
                'required',
            ],
            'immagine' => [
                'required',
            ],
        ];
    }
}
