<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VocePHotel extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'voce_p_hotels';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'info_aggiuntive',
        'hotel_id',
        'preventivo_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function hotel()
    {
        return $this->belongsTo(AlloggioHotel::class, 'hotel_id');
    }

    public function preventivo()
    {
        return $this->belongsTo(Preventivo::class, 'preventivo_id');
    }

    public function vociNotti()
    {
        return VocePHotelPerNotte::where('voce_hotel_id', $this->id)->get();
    }

    public function vociPersona()
    {
        return VocePHotelPerPersona::where('voce_hotel_id', $this->id)->get();
    }    
    
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
