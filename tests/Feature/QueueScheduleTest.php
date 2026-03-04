<?php

use Illuminate\Console\Scheduling\Schedule;

it('schedules the queue worker to run every minute', function () {
    $schedule = app(Schedule::class);

    $event = collect($schedule->events())->first(function ($event) {
        return str_contains($event->command, 'queue:work');
    });

    expect($event)->not->toBeNull();
    expect($event->expression)->toBe('* * * * *');
});
