<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VocePExtraPerPersona extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'voce_p_extra_per_personas';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'servizio_extra_id',
        'prezzo',
        'quantita',
        'scorpora',
        'preventivo_id',
        'info_aggiuntive',
        'quota_comprende',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function servizio_extra()
    {
        return $this->belongsTo(ServizioExtra::class, 'servizio_extra_id');
    }

    public function preventivo()
    {
        return $this->belongsTo(Preventivo::class, 'preventivo_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
