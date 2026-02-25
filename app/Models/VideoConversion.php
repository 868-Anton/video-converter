<?php

namespace App\Models;

use App\Enums\VideoConversionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoConversion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'original_filename',
        'original_size_mb',
        'target_size_mb',
        'achieved_size_mb',
        'input_disk',
        'input_path',
        'output_disk',
        'output_path',
        'duration_seconds',
        'video_bitrate_kbps',
        'audio_bitrate_kbps',
        'status',
        'error_message',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'original_size_mb' => 'decimal:2',
            'target_size_mb' => 'decimal:2',
            'achieved_size_mb' => 'decimal:2',
            'duration_seconds' => 'decimal:2',
            'status' => VideoConversionStatus::class,
        ];
    }
}
