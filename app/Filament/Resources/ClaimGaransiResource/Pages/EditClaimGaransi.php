<?php

namespace App\Filament\Resources\ClaimGaransiResource\Pages;

use App\Filament\Resources\ClaimGaransiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClaimGaransi extends EditRecord
{
    protected static string $resource = ClaimGaransiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
];
}
}