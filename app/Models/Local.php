<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;

    protected $table = 'locaux';

    protected $fillable = [
        'capacite',
        'nom_salle',
        'disponibilite',
    ];


    public function cours()
    {
        return $this->hasMany(Cours::class);
    }
}
