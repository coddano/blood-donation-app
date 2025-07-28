<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DonneurResource\Pages;
use App\Filament\Resources\DonneurResource\RelationManagers;
use App\Models\Donneur;
use App\Models\User;
use App\Models\Ville;
use App\Models\GroupeSanguin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DonneurResource extends Resource
{
    protected static ?string $model = Donneur::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationLabel = 'Donneurs';

    protected static ?string $modelLabel = 'Donneur';

    protected static ?string $pluralModelLabel = 'Donneurs';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Utilisateur')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('ville_id')
                    ->label('Ville')
                    ->relationship('ville', 'nom')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('groupe_sanguin_id')
                    ->label('Groupe Sanguin')
                    ->relationship('groupeSanguin', 'nom')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('telephone')
                    ->label('Téléphone')
                    ->tel()
                    ->required()
                    ->maxLength(20),

                Forms\Components\Toggle::make('disponible')
                    ->label('Disponible')
                    ->default(true)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('groupeSanguin.nom')
                    ->label('Groupe Sanguin')
                    ->badge()
                    ->color('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('ville.nom')
                    ->label('Ville')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('telephone')
                    ->label('Téléphone')
                    ->searchable(),

                Tables\Columns\IconColumn::make('disponible')
                    ->label('Disponible')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Inscrit le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('ville_id')
                    ->label('Ville')
                    ->relationship('ville', 'nom'),

                Tables\Filters\SelectFilter::make('groupe_sanguin_id')
                    ->label('Groupe Sanguin')
                    ->relationship('groupeSanguin', 'nom'),

                Tables\Filters\TernaryFilter::make('disponible')
                    ->label('Disponible'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListDonneurs::route('/'),
            'create' => Pages\CreateDonneur::route('/create'),
            'edit' => Pages\EditDonneur::route('/{record}/edit'),
        ];
    }
}
