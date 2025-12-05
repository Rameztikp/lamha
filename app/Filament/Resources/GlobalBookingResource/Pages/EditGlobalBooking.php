<?php

namespace App\Filament\Resources\GlobalBookingResource\Pages;

use App\Filament\Resources\GlobalBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGlobalBooking extends EditRecord
{
    protected static string $resource = GlobalBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
