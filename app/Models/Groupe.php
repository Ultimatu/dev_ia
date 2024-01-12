<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $fillable = [
        'niveau',
        'filiere',
        'years',
        'classe',

    ];


    public function cours()
    {
        return $this->hasMany(Cours::class);
    }
}
