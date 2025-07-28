<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornitore extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'fornitores';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'nome',
        'cognome',
        'ragione_sociale',
        'piva_cf',
        'indirizzo',
        'citta',
        'cap',
        'provincia',
        'stato',
        'email',
        'telefono',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function fornitoreServizioExtras()
    {
        return $this->hasMany(ServizioExtra::class, 'fornitore_id', 'id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
