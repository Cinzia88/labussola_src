<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Clienti extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'clientis';

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


    public function getNomeCompletoAttribute()
    {
        return $this->nome . ' ' . $this->cognome . ' - ' . $this->ragione_sociale;
    }


    public function clientePreventivos()
    {
        return $this->hasMany(Preventivo::class, 'cliente_id', 'id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @param string $searchString
     * @return mixed
     */
    public static function freeSearchInAllTable(string $searchString) {

        $clientisColumnList = Schema::getColumnListing('clientis');
        $clientisColumnListPurged = [];
        foreach ($clientisColumnList as $column) {
            if ( ! str_ends_with($column, 'id') && ! str_ends_with($column, '_at') ) {
                $clientisColumnListPurged[] = $column;
            }
        }

        $clienti = self::where(reset($clientisColumnListPurged), 'like', "%$searchString%");

        foreach ($clientisColumnListPurged as $key => $column) {
            if ( $key == 0 ) {
                continue;
            }

            $clienti->orWhere($column, 'like', "%$searchString%");
        }

        return $clienti->get();
    }
}
