<?php

namespace App\Http\Requests;

use App\Models\Clienti;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreClientiRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('clienti_create');
    }

    public function rules()
    {
        return [
            'nome' => [
                'string',
                'required',
            ],
            'cognome' => [
                'string',
                'required',
            ],
            'ragione_sociale' => [
                'string',
                'nullable',
            ],
            'piva_cf' => [
                'string',
                'nullable',
            ],
            'indirizzo' => [
                'string',
                'nullable',
            ],
            'citta' => [
                'string',
                'nullable',
            ],
            'cap' => [
                'string',
                'nullable',
            ],
            'provincia' => [
                'string',
                'nullable',
            ],
            'stato' => [
                'string',
                'nullable',
            ],
            'telefono' => [
                'string',
                'nullable',
            ],
        ];
    }
}
