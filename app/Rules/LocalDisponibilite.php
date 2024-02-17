<?php

namespace App\Rules;

use Closure;
use App\Models\Cours;
use Illuminate\Contracts\Validation\Rule;

class LocalDisponibilite implements Rule
{

     /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value){
        $dateCours = request('date_cours');
        $heureDebut = request('heure_debut');
        $heureFin = request('heure_fin');

        // Vérifier la disponibilité du local
        $existingCours = Cours::where('local_id', $value)
            ->where('date_cours', $dateCours)
            ->where(function ($query) use ($heureDebut, $heureFin) {
                $query->where(function ($q) use ($heureDebut, $heureFin) {
                    $q->whereBetween('heure_debut', [$heureDebut, $heureFin])
                        ->orWhereBetween('heure_fin', [$heureDebut, $heureFin]);
                });
            })
            ->exists();

        if ($existingCours) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message(){
        return 'Ce local est occupé à la même heure.';
    }
}
