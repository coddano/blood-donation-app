<?php

namespace App\Filament\Resources\GroupeSanguinResource\Pages;

use App\Filament\Resources\GroupeSanguinResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGroupeSanguin extends EditRecord
{
    protected static string $resource = GroupeSanguinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
