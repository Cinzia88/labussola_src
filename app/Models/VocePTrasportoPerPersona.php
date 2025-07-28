<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VocePTrasportoPerPersona extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const TIPOLOGIA_TRASPORTO_SELECT = [
        'principale' => 'Principale',
        'trasporti'  => 'Trasporti',
    ];

    public const TIPOLOGIA_SELECT = [
        'andata'        => 'Andata',
        'ritorno'       => 'Ritorno',
        'non_specifico' => 'Non specificato',
    ];

    public $table = 'voce_p_trasporto_per_personas';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'tipologia_trasporto',
        'trasporto_id',
        'prezzo',
        'preventivo_id',
        'informazioni_aggiuntive',
        'scorpora',
        'tipologia',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function trasporto()
    {
        return $this->belongsTo(Trasporto::class, 'trasporto_id');
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
