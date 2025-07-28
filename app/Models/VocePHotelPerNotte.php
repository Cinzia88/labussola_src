<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VocePHotelPerNotte extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const TIPOLOGIA_STANZA_SELECT = [
        '1'  => 'Singola',
        '2'  => 'Doppia',
        '3'  => 'Tripla',
        '4'  => 'Quadrupla',
        '5'  => 'Stanza da 5',
        '6'  => 'Stanza da 6',
        '7'  => 'Stanza da 7',
        '8'  => 'Stanza da 8',
        '9'  => 'Stanza da 9',
        '10' => 'Stanza da 10',
        'multipla' => 'Multipla',
    ];

    public $table = 'voce_p_hotel_per_nottes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'tipologia_stanza',
        'numero_stanze',
        'costo_a_notte',
        'voce_hotel_id',
        'scorpora',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function voce_hotel()
    {
        return $this->belongsTo(VocePHotel::class, 'voce_hotel_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
