<?php

namespace Database\Factories;

use App\Enums\VideoConversionStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VideoConversion>
 */
class VideoConversionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'original_filename' => fake()->word().'.mp4',
            'original_size_mb' => fake()->randomFloat(2, 10, 500),
            'target_size_mb' => fake()->randomFloat(2, 1, 100),
            'achieved_size_mb' => null,
            'input_disk' => 'video_uploads',
            'input_path' => 'uploads/'.Str::uuid().'.mp4',
            'output_disk' => 'video_converted',
            'output_path' => 'converted_'.Str::uuid().'.mp4',
            'duration_seconds' => null,
            'video_bitrate_kbps' => null,
            'audio_bitrate_kbps' => 128,
            'status' => VideoConversionStatus::Pending,
            'error_message' => null,
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => VideoConversionStatus::Pending]);
    }

    public function processing(): static
    {
        return $this->state(['status' => VideoConversionStatus::Processing]);
    }

    public function completed(): static
    {
        return $this->state([
            'status' => VideoConversionStatus::Completed,
            'achieved_size_mb' => fake()->randomFloat(2, 1, 100),
            'duration_seconds' => fake()->randomFloat(2, 10, 3600),
            'video_bitrate_kbps' => fake()->numberBetween(200, 4000),
        ]);
    }

    public function failed(): static
    {
        return $this->state([
            'status' => VideoConversionStatus::Failed,
            'error_message' => fake()->sentence(),
        ]);
    }
}
