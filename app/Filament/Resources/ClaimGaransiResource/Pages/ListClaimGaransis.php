<?php

namespace App\Filament\Resources\ClaimGaransiResource\Pages;

use App\Filament\Resources\ClaimGaransiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClaimGaransis extends ListRecords
{
    protected static string $resource = ClaimGaransiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
  ];
}
}