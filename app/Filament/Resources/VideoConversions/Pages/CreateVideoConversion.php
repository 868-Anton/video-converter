<?php

namespace App\Filament\Resources\VideoConversions\Pages;

use App\Filament\Resources\VideoConversions\VideoConversionResource;
use App\Jobs\ConvertVideoJob;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateVideoConversion extends CreateRecord
{
    protected static string $resource = VideoConversionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['input_disk'] = 'video_uploads';
        $data['output_disk'] = 'video_converted';
        $data['output_path'] = 'converted_'.Str::uuid().'.mp4';

        if (isset($data['input_path'])) {
            $fileSizeBytes = Storage::disk('video_uploads')->size($data['input_path']);
            $data['original_size_mb'] = round($fileSizeBytes / 1024 / 1024, 2);
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        ConvertVideoJob::dispatch($this->record);
    }
}
