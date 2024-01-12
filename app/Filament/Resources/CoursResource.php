<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoursResource\Pages;
use App\Filament\Resources\CoursResource\RelationManagers;
use App\Models\Cours;
use App\Rules\EnseignantDisponibilite;
use App\Rules\GroupeDisponibilite;
use App\Rules\LocalDisponibilite;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CoursResource extends Resource
{
    protected static ?string $model = Cours::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Cours';

    protected static ?string $label = 'Cours';



    private function disponibleTeacher($teacherId, $dateCours, $heureDebut, $heureFin)
    {
        // Vérifier si l'enseignant a déjà un cours à la même date et pendant le même intervalle horaire
        $existingCours = Cours::where('teacher_id', $teacherId)
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

        return !$existingCours;
    }

    private function disponibleLocal($localId, $dateCours, $heureDebut, $heureFin)
    {
        // Vérifier si le local est disponible à la même date et pendant le même intervalle horaire
        $existingCours = Cours::where('local_id', $localId)
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

        return !$existingCours;
    }

    private function disponibleGroupe($groupeId, $dateCours, $heureDebut, $heureFin)
    {
        // Vérifier si le groupe est disponible à la même date et pendant le même intervalle horaire
        $existingCours = Cours::where('groupe_id', $groupeId)
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

        return !$existingCours;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\BelongsToSelect::make('groupe_id')
                    ->relationship('groupe',  'classe')
                    ->required()
                    ->rules([new GroupeDisponibilite]),
                Forms\Components\BelongsToSelect::make('teacher_id')
                    ->relationship('enseignant', 'nom')
                    ->required()
                    ->rules([new EnseignantDisponibilite]),
                Forms\Components\BelongsToSelect::make('local_id')
                    ->relationship('local', 'nom_salle')
                    ->required()
                    ->rules([new LocalDisponibilite]),
                Forms\Components\DatePicker::make('date_cours')
                    ->required(),
                Forms\Components\TimePicker::make('heure_debut')
                    ->required(),
                Forms\Components\TimePicker::make('heure_fin')
                    ->required(),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('groupe.classe')
                    ->sortable(),
                Tables\Columns\TextColumn::make('enseignant.prenom')
                    ->sortable(),
                Tables\Columns\TextColumn::make('local.nom_salle')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_cours')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('heure_debut')->time(),
                Tables\Columns\TextColumn::make('heure_fin')->time(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCours::route('/'),
            'create' => Pages\CreateCours::route('/create'),
            'edit' => Pages\EditCours::route('/{record}/edit'),
        ];
    }
}
