<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'phone',
        'matiere',
        'disponibilite',
    ];

    public function cours()
    {
        return $this->hasMany(Cours::class);
    }


}
