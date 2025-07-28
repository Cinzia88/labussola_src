<?php

namespace App\Models;

use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AlloggioHotel extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use Auditable;
    use HasFactory;

    public const STELLE_SELECT = [
        'non_ha_stelle' => 'Non dispone di stelle',
        'una'           => 'Una stella',
        'due'           => 'Due stelle',
        'tre'           => 'Tre stelle',
        'quattro'       => 'Quattro stelle',
        'cinque'        => 'Cinque stelle',
    ];

    public $table = 'alloggio_hotels';

    protected $appends = [
        'foto',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'nome',
        'indirizzo',
        'descrizione',
        'stelle',
        'fornitore_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function hotelVocePHotels()
    {
        return $this->hasMany(VocePHotel::class, 'hotel_id', 'id');
    }

    public function getStellaAttribute()
    {
        if ($this->stelle == 'non_ha_stelle') return '';
        switch ($this->stelle) {
            case 'una':
                return  '<img  class="stelle" src="/images/stella.png">
                <img  class="stelle" src="/images/stellavuota.png">
                <img  class="stelle" src="/images/stellavuota.png">
                <img  class="stelle" src="/images/stellavuota.png">
                <img  class="stelle" src="/images/stellavuota.png">';
                break;
            case 'due':
                return  '<img  class="stelle" src="/images/stella.png">
                <img  class="stelle"  src="/images/stella.png">
                <img  class="stelle" src="/images/stellavuota.png">
                <img  class="stelle" src="/images/stellavuota.png">
                <img  class="stelle" src="/images/stellavuota.png">';
                break;
            case 'tre':
                return  '<img  class="stelle" src="/images/stella.png">
                <img  class="stelle" src="/images/stella.png">
                <img  class="stelle" src="/images/stella.png">
                <img  class="stelle" src="/images/stellavuota.png">
                <img  class="stelle" src="/images/stellavuota.png">';
                break;
            case 'quattro':
                return  '<img  class="stelle" src="/images/stella.png">
                <img  class="stelle" src="/images/stella.png">
                <img  class="stelle" src="/images/stella.png">
                <img  class="stelle" src="/images/stella.png">
                <img  class="stelle" src="/images/stellavuota.png">';
                break;
            case 'cinque':
               return  '<img  class="stelle" src="/images/stella.png">
               <img  class="stelle" src="/images/stella.png">
               <img  class="stelle" src="/images/stella.png">
               <img  class="stelle" src="/images/stella.png">
               <img  class="stelle" src="/images/stellavuota.png">';
                break;
        }
        return AlloggioHotel::STELLE_SELECT[$this->stelle];
    }

    public function getFotoAttribute()
    {
        $files = $this->getMedia('foto');
        $files->each(function ($item) {
            $item->url = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview = $item->getUrl('preview');
        });

        return $files;
    }

    public function fornitore()
    {
        return $this->belongsTo(Fornitore::class, 'fornitore_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
