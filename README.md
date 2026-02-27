# Anton's Video Converter Tool

A Laravel + Filament admin tool for converting video files to a target file size using FFMpeg two-pass encoding.

## What it does

Upload any video (MP4, MOV, AVI, MKV, WebM) and specify a target output size in MB. The app calculates the optimal video bitrate and runs a two-pass FFMpeg encode in the background to hit that size as closely as possible. You can track the job status in real time and download the converted file when it's done.

## Tech stack

- **Laravel 12** — application framework
- **Filament v5** — admin UI (list, create, view pages)
- **Livewire v4** — reactive file upload
- **FFMpeg** (via `pbmedia/laravel-ffmpeg`) — two-pass video encoding
- **Laravel Queues** — background job processing
- **SQLite** — database

## Features

- Upload video files up to 2GB
- Set a target output size in MB
- Set a custom audio bitrate (default 128 kbps)
- Background queue job with two-pass encoding for accurate file size targeting
- Status tracking: Pending → Processing → Completed / Failed
- Color-coded status badges
- Download converted file directly from the UI
- Error messages displayed on failed conversions

## Setup

See [RUNNING.md](RUNNING.md) for full setup and running instructions.

### Quick start

```bash
composer install
php artisan migrate
php artisan make:filament-user

# In a separate terminal — required for conversions to process
php artisan queue:work --timeout=3600 --memory=512
```

The admin panel is available at **http://video-converter.test/admin** via Laravel Herd.

## How the encoding works

Given a target size and video duration, the app computes the required video bitrate:

```
video_bitrate = (target_size_MB × 1024 × 8 / duration_seconds) − audio_bitrate
```

FFMpeg then runs two passes at that bitrate — pass 1 analyses the video, pass 2 encodes it — producing a file that lands as close to the target size as possible.
