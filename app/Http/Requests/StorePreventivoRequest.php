<?php

namespace App\Http\Requests;

use App\Models\Preventivo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePreventivoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('preventivo_create');
    }

    public function rules()
    {
        return [
            'oggetto' => [
                'string',
                'nullable',
            ],
            'cliente_id' => [
                'required',
                'integer',
            ],
            'numero_persone' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'prezzo_per_persona' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'status' => [
                'required',
            ],
            'data_inzio_viaggio' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'data_fine_viaggio' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'guid' => [
                'string',
                'required',
                'unique:preventivos',
            ],
            'viewkey' => [
                'string',
                'required',
                'unique:preventivos',
            ],
            'luogo_di_partenza_andata' => [
                'string',
                'max:255',
                'nullable',
            ],
            'luogo_di_arrivo_andata' => [
                'string',
                'max:255',
                'nullable',
            ],
            'data_ora_partenza_andata' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'data_ora_rientro_andata' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'luogo_di_partenza_rientro' => [
                'string',
                'nullable',
            ],
            'luogo_di_arrivo_rientro' => [
                'string',
                'nullable',
            ],
            'data_ora_partenza_rientro' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'data_ora_rientro_rientro' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'numero_gratuita' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'markup' => [
                'required',
            ],
            'kg_bg_a_mano_andata' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'kg_bg_a_mano_ritorno' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'kg_bg_in_stiva_andata' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'kg_bg_in_stiva_ritorno' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'files_pratica' => [
                'array',
            ],
        ];
    }
}
