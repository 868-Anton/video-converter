# Running Anton's Video Converter Tool

## Prerequisites

- **PHP 8.5** via [Laravel Herd](https://herd.laravel.com)
- **FFMpeg** installed (`brew install ffmpeg`)
- **Composer** dependencies installed (`composer install`)

## First-time setup

```bash
# Run database migrations
php artisan migrate

# Create an admin user
php artisan make:filament-user
```

## Starting the application

The site is served automatically by Laravel Herd at:
**http://video-converter.test/admin**

## Required: Queue worker

Video conversions run as background jobs. You **must** keep this running in a terminal for conversions to process:

```bash
php artisan queue:work --timeout=3600 --memory=512
```

| Flag | Value | Reason |
|---|---|---|
| `--timeout` | `3600` | Allows up to 1 hour per conversion |
| `--memory` | `512` | Gives FFMpeg enough RAM for large files |

> Stop the worker with `Ctrl+C`. Any job currently running will fail — resubmit it from the UI.

## Environment variables

Ensure these are set correctly in `.env`:

```env
QUEUE_CONNECTION=database

FFMPEG_BINARIES=/usr/local/bin/ffmpeg
FFPROBE_BINARIES=/usr/local/bin/ffprobe
```

Verify FFMpeg is installed at the expected path:

```bash
which ffmpeg   # should print /usr/local/bin/ffmpeg
which ffprobe  # should print /usr/local/bin/ffprobe
```

## Upload limits

The following have been configured to support large video files:

| Layer | Limit |
|---|---|
| Nginx (`video-converter.test`) | 2048 MB |
| PHP `upload_max_filesize` | 2 GB |
| PHP `post_max_size` | 2 GB |
| Livewire temporary upload | 2 GB |

These are set in:
- `~/Library/Application Support/Herd/config/valet/Nginx/video-converter.test`
- `~/Library/Application Support/Herd/config/php/85/php.ini`
- `config/livewire.php` → `temporary_file_upload.rules`
