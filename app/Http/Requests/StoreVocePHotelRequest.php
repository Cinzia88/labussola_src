<?php

namespace App\Http\Requests;

use App\Models\VocePHotel;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVocePHotelRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('voce_p_hotel_create');
    }

    public function rules()
    {
        return [
            'hotel_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
