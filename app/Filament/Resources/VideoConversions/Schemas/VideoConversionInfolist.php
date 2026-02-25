<?php

namespace App\Filament\Resources\VideoConversions\Schemas;

use App\Enums\VideoConversionStatus;
use App\Models\VideoConversion;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VideoConversionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('original_filename'),

                TextEntry::make('original_size_mb')
                    ->suffix(' MB'),

                TextEntry::make('target_size_mb')
                    ->suffix(' MB'),

                TextEntry::make('achieved_size_mb')
                    ->suffix(' MB')
                    ->placeholder('—'),

                TextEntry::make('status')
                    ->badge(),

                TextEntry::make('audio_bitrate_kbps')
                    ->suffix(' kbps'),

                TextEntry::make('video_bitrate_kbps')
                    ->suffix(' kbps')
                    ->placeholder('—'),

                TextEntry::make('duration_seconds')
                    ->suffix(' s')
                    ->placeholder('—'),

                TextEntry::make('output_path')
                    ->placeholder('—'),

                TextEntry::make('error_message')
                    ->visible(fn (VideoConversion $record): bool => $record->status === VideoConversionStatus::Failed)
                    ->columnSpanFull(),

                TextEntry::make('created_at')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
