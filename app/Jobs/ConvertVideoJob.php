<?php

namespace App\Jobs;

use App\Enums\VideoConversionStatus;
use App\Models\VideoConversion;
use App\Services\VideoConverterService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class ConvertVideoJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $timeout = 3600;

    public int $tries = 1;

    public function __construct(public VideoConversion $videoConversion)
    {
    }

    public function handle(VideoConverterService $videoConverterService): void
    {
        try {
            $this->videoConversion->update([
                'status' => VideoConversionStatus::Processing,
            ]);

            $result = $videoConverterService->convertToTargetSize(
                $this->videoConversion->input_path,
                $this->videoConversion->target_size_mb,
            );

            $this->videoConversion->update([
                'achieved_size_mb' => $result['achieved_size_mb'],
                'duration_seconds' => $result['duration_seconds'],
                'video_bitrate_kbps' => $result['video_bitrate_kbps'],
                'output_path' => $result['output_path'],
                'status' => VideoConversionStatus::Completed,
            ]);
        } catch (Throwable $throwable) {
            $this->videoConversion->update([
                'status' => VideoConversionStatus::Failed,
                'error_message' => $throwable->getMessage(),
            ]);

            Log::error('Video conversion failed.', [
                'video_conversion_id' => $this->videoConversion->id,
                'error_message' => $throwable->getMessage(),
            ]);

            throw $throwable;
        }
    }
}
