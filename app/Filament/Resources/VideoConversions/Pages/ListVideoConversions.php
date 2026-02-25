<?php

namespace App\Filament\Resources\VideoConversions\Pages;

use App\Filament\Resources\VideoConversions\VideoConversionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVideoConversions extends ListRecords
{
    protected static string $resource = VideoConversionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
