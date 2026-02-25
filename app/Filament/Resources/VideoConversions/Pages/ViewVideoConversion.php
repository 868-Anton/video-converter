<?php

namespace App\Filament\Resources\VideoConversions\Pages;

use App\Enums\VideoConversionStatus;
use App\Filament\Resources\VideoConversions\VideoConversionResource;
use App\Models\VideoConversion;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewVideoConversion extends ViewRecord
{
    protected static string $resource = VideoConversionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('download')
                ->label('Download')
                ->icon(Heroicon::OutlinedArrowDownTray)
                ->color('success')
                ->url(fn (VideoConversion $record): string => route('video-conversions.download', $record))
                ->openUrlInNewTab()
                ->visible(fn (VideoConversion $record): bool => $record->status === VideoConversionStatus::Completed),
        ];
    }
}
