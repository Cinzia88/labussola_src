<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scadenziario extends Model
{
    use SoftDeletes;
    use MultiTenantModelTrait;
    use Auditable;
    use HasFactory;

    public $table = 'scadenziarios';

    public static $searchable = [
        'nome',
    ];

    protected $dates = [
        'data',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'nome',
        'colore_eticchetta',
        'data',
        'eseguito',
        'preventivo_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    public const COLORE_ETICCHETTA_SELECT = [
        'rossofc' => 'Rosso',
        'verdefc' => 'Verde',
        'blufc' => 'Blu',
        'giallofc' => 'Giallo',
        'arancionefc' => 'Arancione',
        'violafc' => 'Viola',
    ];

    public function getDataAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function preventivo()
    {
        return $this->belongsTo(Preventivo::class, 'preventivo_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
