<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalMedicalHistory extends Model
{
    use HasFactory;

    protected $fillable = ['animal_id', 'specialist_id', 'modification'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function specialist()
    {
        return $this->belongsTo(User::class, 'specialist_id');
    }
}
