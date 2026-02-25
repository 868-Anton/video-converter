<?php

namespace App\Filament\Resources\VideoConversions\Pages;

use App\Filament\Resources\VideoConversions\VideoConversionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditVideoConversion extends EditRecord
{
    protected static string $resource = VideoConversionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
