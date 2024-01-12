<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $fillable = [
        'groupe_id',
        'teacher_id',
        'local_id',
        'date_cours',
        'heure_debut',
        'heure_fin',
    ];

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'teacher_id');
    }


    public function local()
    {
        return $this->belongsTo(Local::class);
    }


}
