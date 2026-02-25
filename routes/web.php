<?php

use App\Models\VideoConversion;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/video-conversions/{videoConversion}/download', function (VideoConversion $videoConversion) {
    abort_unless($videoConversion->output_path && Storage::disk($videoConversion->output_disk)->exists($videoConversion->output_path), 404);

    return Storage::disk($videoConversion->output_disk)->download(
        $videoConversion->output_path,
        $videoConversion->original_filename,
    );
})->middleware('auth')->name('video-conversions.download');
