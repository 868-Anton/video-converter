<?php

use App\Enums\VideoConversionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('video_conversions', function (Blueprint $table) {
            $table->id();
            $table->string('original_filename');
            $table->decimal('original_size_mb', 8, 2);
            $table->decimal('target_size_mb', 8, 2);
            $table->decimal('achieved_size_mb', 8, 2)->nullable();
            $table->string('input_disk')->default('video_uploads');
            $table->string('input_path');
            $table->string('output_disk')->default('video_converted');
            $table->string('output_path')->nullable();
            $table->decimal('duration_seconds', 10, 2)->nullable();
            $table->integer('video_bitrate_kbps')->nullable();
            $table->integer('audio_bitrate_kbps')->default(128);
            $table->string('status')->default(VideoConversionStatus::Pending->value);
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_conversions');
    }
};
