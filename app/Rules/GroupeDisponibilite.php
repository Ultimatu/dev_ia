<?php

namespace App\Rules;

use App\Models\Cours;
use Closure;
use Illuminate\Contracts\Validation\Rule;

class GroupeDisponibilite implements Rule
{


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Récupérer les données de la requête
        $requestData = request()->all();
        // Récupérer les mises à jour
        $updates = $requestData['components'][0]['updates'];
        dd($updates);
        $dateCours = $updates['data.date_cours'];
        $heureDebut = $updates['data.heure_debut'];
        $heureFin = $updates['data.heure_fin'];

        // Vérifier la disponibilité du groupe
        $existingCours = Cours::where('groupe_id', $value)
            ->where('date_cours', $dateCours)
            ->where(function ($query) use ($heureDebut, $heureFin) {
                $query->where(function ($q) use ($heureDebut, $heureFin) {
                    $q->whereBetween('heure_debut', [$heureDebut, $heureFin])
                        ->orWhereBetween('heure_fin', [$heureDebut, $heureFin]);
                })->orWhere(function ($q) use ($heureDebut, $heureFin) {
                    $q->where('heure_debut', '<=', $heureDebut)
                        ->where('heure_fin', '>=', $heureFin);
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
    public function message()
    {
        return 'Ce groupe est occupé à la même heure.';
    }
}
