<?php

namespace App\Filament\Resources\VideoConversions\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VideoConversionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('input_path')
                    ->label('Video File')
                    ->disk('video_uploads')
                    ->acceptedFileTypes([
                        'video/mp4',
                        'video/quicktime',
                        'video/x-msvideo',
                        'video/x-matroska',
                        'video/webm',
                    ])
                    ->storeFileNamesIn('original_filename')
                    ->required(),

                TextInput::make('target_size_mb')
                    ->label('Target Size (MB)')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(10000)
                    ->suffix('MB')
                    ->required(),

                TextInput::make('audio_bitrate_kbps')
                    ->label('Audio Bitrate')
                    ->numeric()
                    ->default(128)
                    ->minValue(64)
                    ->maxValue(320)
                    ->suffix('kbps'),
            ]);
    }
}
