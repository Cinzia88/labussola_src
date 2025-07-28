<?php

namespace App\Http\Requests;

use App\Models\AlloggioHotel;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAlloggioHotelRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('alloggio_hotel_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:alloggio_hotels,id',
        ];
    }
}
