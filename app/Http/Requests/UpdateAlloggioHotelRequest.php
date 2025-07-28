<?php

namespace App\Http\Requests;

use App\Models\AlloggioHotel;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAlloggioHotelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('alloggio_hotel_edit');
    }

    public function rules()
    {
        return [
            'nome' => [
                'string',
                'required',
            ],
            'indirizzo' => [
                'string',
                'nullable',
            ],
            'foto' => [
                'array',
            ],
            'stelle' => [
                'required',
            ],
        ];
    }
}
