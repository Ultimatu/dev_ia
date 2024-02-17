<?php

namespace App\Filament\Resources\CoursResource\Pages;

use App\Filament\Resources\CoursResource;
use App\Models\Cours;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCours extends CreateRecord
{
    protected static string $resource = CoursResource::class;

    // public function beforeCreate()
    // {
    //     dd($this->getRecord());
    //     // Récupérer les données de la requête
    //     $requestData = request()->all();
    //     // Récupérer les mises à jour
    //     $updates = $requestData['components'][0]['updates'];
    //     dd($updates);
    //     $dateCours = $updates['data.date_cours'];
    //     $heureDebut = $updates['data.heure_debut'];
    //     $heureFin = $updates['data.heure_fin'];
    //     $groupe_id = $updates('data.groupe_id');
    //     $local_id = $updates('data.local_id');
    //     $teacher_id = $updates('data.teacher_id');
    //     $existingCours = Cours::where('groupe_id', $groupe_id)
    //         ->where('date_cours', $dateCours)
    //         ->where(function ($query) use ($heureDebut, $heureFin) {
    //             $query->where(function ($q) use ($heureDebut, $heureFin) {
    //                 $q->whereBetween('heure_debut', [$heureDebut, $heureFin])
    //                     ->orWhereBetween('heure_fin', [$heureDebut, $heureFin]);
    //             });
    //         })
    //         ->exists();
    //     if ($existingCours) {
    //         return redirect()->back()->with('error', 'Ce groupe est occupé à la même heure.');
    //     }
    //     $existingCours = Cours::where('local_id', $local_id)
    //         ->where('date_cours', $dateCours)
    //         ->where(function ($query) use ($heureDebut, $heureFin) {
    //             $query->where(function ($q) use ($heureDebut, $heureFin) {
    //                 $q->whereBetween('heure_debut', [$heureDebut, $heureFin])
    //                     ->orWhereBetween('heure_fin', [$heureDebut, $heureFin]);
    //             });
    //         })
    //         ->exists();
    //     if ($existingCours) {
    //         return redirect()->back()->with('error', 'Ce local est occupé à la même heure.');
    //     }
    //     $existingCours = Cours::where('teacher_id', $teacher_id)
    //         ->where('date_cours', $dateCours)
    //         ->where(function ($query) use ($heureDebut, $heureFin) {
    //             $query->where(function ($q) use ($heureDebut, $heureFin) {
    //                 $q->whereBetween('heure_debut', [$heureDebut, $heureFin])
    //                     ->orWhereBetween('heure_fin', [$heureDebut, $heureFin]);
    //             });
    //         })
    //         ->exists();
    //     if ($existingCours) {
    //         return redirect()->back()->with('error', 'Cet enseignant est occupé à la même heure.');

    //     }

    // }



}
