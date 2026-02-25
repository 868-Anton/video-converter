<?php

namespace App\Services;

use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use RuntimeException;

class VideoConverterService
{
    /**
     * @return array{
     *     output_path: string,
     *     target_size_mb: float,
     *     achieved_size_mb: float,
     *     video_bitrate_kbps: int,
     *     audio_bitrate_kbps: int,
     *     duration_seconds: float
     * }
     */
    public function convertToTargetSize(
        string $inputDisk,
        string $inputPath,
        string $outputDisk,
        string $outputPath,
        float $targetSizeMB,
        int $audioBitrate = 128
    ): array {
        $media = FFMpeg::fromDisk($inputDisk)->open($inputPath);

        $durationSeconds = $media->getDurationInSeconds();
        $videoBitrate = $this->calculateVideoBitrate($targetSizeMB, $durationSeconds, $audioBitrate);

        if ($videoBitrate <= 0) {
            throw new RuntimeException('Calculated video bitrate must be greater than zero.');
        }

        $format = (new X264())
            ->setKiloBitrate($videoBitrate)
            ->setAudioKiloBitrate($audioBitrate)
            ->setPasses(2);

        $media->export()
            ->toDisk($outputDisk)
            ->inFormat($format)
            ->save($outputPath);

        $outputFile = Storage::disk($outputDisk);

        if (! $outputFile->exists($outputPath)) {
            throw new RuntimeException("Converted file was not found at [{$outputDisk}:{$outputPath}].");
        }

        $achievedSizeMB = $outputFile->size($outputPath) / 1024 / 1024;

        return [
            'output_path' => $outputPath,
            'target_size_mb' => $targetSizeMB,
            'achieved_size_mb' => $achievedSizeMB,
            'video_bitrate_kbps' => $videoBitrate,
            'audio_bitrate_kbps' => $audioBitrate,
            'duration_seconds' => $durationSeconds,
        ];
    }

    private function calculateVideoBitrate(float $targetSizeMB, float $durationSeconds, int $audioBitrate): int
    {
        if ($durationSeconds <= 0) {
            throw new RuntimeException('Video duration must be greater than zero seconds.');
        }

        $targetSizeKB = $targetSizeMB * 1024;
        $targetSizeKbits = $targetSizeKB * 8;
        $totalKbps = $targetSizeKbits / $durationSeconds;
        $videoBitrate = $totalKbps - $audioBitrate;

        return (int) floor($videoBitrate);
    }
}
