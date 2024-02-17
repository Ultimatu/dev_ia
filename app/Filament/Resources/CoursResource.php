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
use Filament\Forms\Components\Wizard;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class CoursResource extends Resource
{
    protected static ?string $model = Cours::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Cours';

    protected static ?string $label = 'Cours';

    protected static ?string $pluralLabel = 'Cours';

    public static function form(Form $form): Form
    {
        $itemModel = $form->getRecord();
        return $form

            ->schema([
                Wizard::make([
                    // separer heure debut et fin dans un autre wizard pour s'assurer que date_cours est saisie avant
                    Wizard\Step::make('Informations')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Forms\Components\BelongsToSelect::make('groupe_id')
                                ->relationship('groupe', 'classe')
                                ->required(),
                            Forms\Components\BelongsToSelect::make('teacher_id')
                                ->relationship('enseignant', 'nom')
                                ->required(),
                            Forms\Components\BelongsToSelect::make('local_id')
                                ->relationship('local', 'nom_salle')
                                ->required(),
                            Forms\Components\DatePicker::make('date_cours')
                                ->minDate(now()->format('Y-m-d'))
                                ->required(),
                        ]),
                    Wizard\Step::make('Heure')
                        ->icon('heroicon-o-clock')
                        ->schema([
                            Forms\Components\TimePicker::make('heure_debut')
                                // Vérifie si $itemModel existe avant d'accéder à ses propriétés
                                ->minDate($itemModel ? now()->format('Y-m-d') === $itemModel->date_cours ? now()->format('H:i') : '08:00' : '08:00')
                                ->required(),
                            Forms\Components\TimePicker::make('heure_fin')
                                ->minDate($itemModel ? now()->format('Y-m-d') === $itemModel->date_cours ? now()->format('H:i') : '08:00' : '08:00')
                        ]),
                ])->submitAction(new HtmlString(Blade::render(<<<BLADE
                <x-filament::button
                    type="submit"
                    size="sm"
                >
                    Submit
                </x-filament::button>
            BLADE))),
            ])->columns(1);

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
