<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupeResource\Pages;
use App\Filament\Resources\GroupeResource\RelationManagers;
use App\Models\Groupe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroupeResource extends Resource
{
    protected static ?string $model = Groupe::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = "Groupe d'etudiant";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('years')
                    ->label("Année Scolaire")
                    ->required(),
                Forms\Components\TextInput::make('filiere')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('niveau')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('classe')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('years')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('filiere')
                    ->searchable(),
                Tables\Columns\TextColumn::make('niveau')
                    ->searchable(),
                Tables\Columns\TextColumn::make('classe')
                    ->searchable(),
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
            'index' => Pages\ListGroupes::route('/'),
            'create' => Pages\CreateGroupe::route('/create'),
            'edit' => Pages\EditGroupe::route('/{record}/edit'),
        ];
    }
}
