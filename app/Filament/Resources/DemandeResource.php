<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DemandeResource\Pages;
use App\Filament\Resources\DemandeResource\RelationManagers;
use App\Models\Demande;
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

class DemandeResource extends Resource
{
    protected static ?string $model = Demande::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $navigationLabel = 'Demandes';

    protected static ?string $modelLabel = 'Demande';

    protected static ?string $pluralModelLabel = 'Demandes';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Demandeur')
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
                    ->label('Groupe Sanguin Demandé')
                    ->relationship('groupeSanguin', 'nom')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Select::make('statut')
                    ->label('Statut')
                    ->options([
                        'en attente' => 'En attente',
                        'traitée' => 'Traitée',
                        'annulée' => 'Annulée',
                    ])
                    ->default('en attente')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Demandeur')
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

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                Tables\Columns\TextColumn::make('statut')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'en attente' => 'warning',
                        'traitée' => 'success',
                        'annulée' => 'danger',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créée le')
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

                Tables\Filters\SelectFilter::make('statut')
                    ->label('Statut')
                    ->options([
                        'en attente' => 'En attente',
                        'traitée' => 'Traitée',
                        'annulée' => 'Annulée',
                    ]),
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
            'index' => Pages\ListDemandes::route('/'),
            'create' => Pages\CreateDemande::route('/create'),
            'edit' => Pages\EditDemande::route('/{record}/edit'),
        ];
    }
}
