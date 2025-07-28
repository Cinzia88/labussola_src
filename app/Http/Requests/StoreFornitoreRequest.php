<?php

namespace App\Http\Requests;

use App\Models\Fornitore;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFornitoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fornitore_create');
    }

    public function rules()
    {
        return [
            'nome' => [
                'string',
                'nullable',
            ],
            'cognome' => [
                'string',
                'nullable',
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
