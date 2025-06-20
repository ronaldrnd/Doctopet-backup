<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Http;

class Cabinet extends Model
{
    use HasFactory;
    protected $table = 'cabinet';
    protected $fillable = ['nom', 'adresse', 'tel'];

    public function veterinarians()
    {
        return $this->belongsToMany(VetoExt::class, 'spe_has_cabinet', 'cabinet_id', 'veto_ext_id');
    }

    public function veterinaires()
    {
        return $this->belongsToMany(VetoExt::class, 'spe_has_cabinet', 'cabinet_id', 'veto_ext_id');
    }


    public function updateCoordinates()
    {
        $address = "{$this->adresse}, France";
        if($address){
            $geoResponse = Http::withHeaders([
                'User-Agent' => 'DoctoPet/1.0 (contact@votreapp.com)',
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q' => $address,
                'format' => 'json',
                'limit' => 1,
            ]);
            if ($geoResponse->successful() && count($geoResponse->json()) > 0) {
                $geoData = $geoResponse->json()[0];
                $this->latitude = $geoData['lat'];
                $this->longitude = $geoData['lon'];
                $this->save();

            }
        }
    }
}
