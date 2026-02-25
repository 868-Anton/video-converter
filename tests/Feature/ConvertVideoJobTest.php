<?php

use App\Enums\VideoConversionStatus;
use App\Jobs\ConvertVideoJob;
use App\Models\VideoConversion;
use App\Services\VideoConverterService;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\mock;

uses(RefreshDatabase::class);

it('sets status to processing then completed on success', function () {
    $conversion = VideoConversion::factory()->create([
        'target_size_mb' => 10,
        'audio_bitrate_kbps' => 128,
    ]);

    $result = [
        'output_path' => $conversion->output_path,
        'target_size_mb' => 10.0,
        'achieved_size_mb' => 9.8,
        'video_bitrate_kbps' => 800,
        'audio_bitrate_kbps' => 128,
        'duration_seconds' => 120.0,
    ];

    mock(VideoConverterService::class)
        ->shouldReceive('convertToTargetSize')
        ->once()
        ->andReturn($result);

    (new ConvertVideoJob($conversion))->handle(app(VideoConverterService::class));

    $conversion->refresh();

    expect($conversion->status)->toBe(VideoConversionStatus::Completed)
        ->and($conversion->achieved_size_mb)->toBe('9.80')
        ->and($conversion->video_bitrate_kbps)->toBe(800)
        ->and($conversion->duration_seconds)->toBe('120.00')
        ->and($conversion->error_message)->toBeNull();
});

it('sets status to failed and stores error message on exception', function () {
    $conversion = VideoConversion::factory()->create();

    mock(VideoConverterService::class)
        ->shouldReceive('convertToTargetSize')
        ->once()
        ->andThrow(new RuntimeException('FFMpeg encoding failed'));

    expect(fn () => (new ConvertVideoJob($conversion))->handle(app(VideoConverterService::class)))
        ->toThrow(\RuntimeException::class, 'FFMpeg encoding failed');

    $conversion->refresh();

    expect($conversion->status)->toBe(VideoConversionStatus::Failed)
        ->and($conversion->error_message)->toBe('FFMpeg encoding failed');
});

it('transitions status to processing before calling the service', function () {
    $conversion = VideoConversion::factory()->pending()->create();

    $statusDuringConversion = null;

    mock(VideoConverterService::class)
        ->shouldReceive('convertToTargetSize')
        ->once()
        ->andReturnUsing(function () use ($conversion, &$statusDuringConversion) {
            $statusDuringConversion = $conversion->fresh()->status;

            return [
                'output_path' => $conversion->output_path,
                'target_size_mb' => $conversion->target_size_mb,
                'achieved_size_mb' => 9.8,
                'video_bitrate_kbps' => 800,
                'audio_bitrate_kbps' => 128,
                'duration_seconds' => 120.0,
            ];
        });

    (new ConvertVideoJob($conversion))->handle(app(VideoConverterService::class));

    expect($statusDuringConversion)->toBe(VideoConversionStatus::Processing);
});
