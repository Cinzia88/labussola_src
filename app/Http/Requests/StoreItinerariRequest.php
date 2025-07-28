<?php

namespace App\Http\Requests;

use App\Models\Itinerari;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreItinerariRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('itinerari_create');
    }

    public function rules()
    {
        return [
            'nome' => [
                'string',
                'required',
            ],
            'foto_introduttiva' => [
                'required',
            ],
            'immagini' => [
                'array',
            ],
        ];
    }
}
