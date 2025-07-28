<?php

namespace App\Http\Requests;

use App\Models\VocePHotelPerNotte;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVocePHotelPerNotteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('voce_p_hotel_per_notte_create');
    }

    public function rules()
    {
        return [
            'tipologia_stanza' => [
                'required',
            ],
            'numero_stanze' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'costo_a_notte' => [
                'required',
            ],
            'voce_hotel_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
