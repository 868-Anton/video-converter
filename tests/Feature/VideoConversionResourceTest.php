<?php

use App\Enums\VideoConversionStatus;
use App\Filament\Resources\VideoConversions\Pages\CreateVideoConversion;
use App\Filament\Resources\VideoConversions\Pages\ListVideoConversions;
use App\Filament\Resources\VideoConversions\Pages\ViewVideoConversion;
use App\Jobs\ConvertVideoJob;
use App\Models\VideoConversion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

describe('List page', function () {
    it('loads successfully', function () {
        Livewire::test(ListVideoConversions::class)
            ->assertOk();
    });

    it('displays video conversion records', function () {
        $conversions = VideoConversion::factory()->count(3)->create();

        Livewire::test(ListVideoConversions::class)
            ->assertOk()
            ->assertCanSeeTableRecords($conversions);
    });

    it('can filter by status', function () {
        $completed = VideoConversion::factory()->completed()->create();
        $pending = VideoConversion::factory()->pending()->create();

        Livewire::test(ListVideoConversions::class)
            ->filterTable('status', VideoConversionStatus::Completed->value)
            ->assertCanSeeTableRecords([$completed])
            ->assertCanNotSeeTableRecords([$pending]);
    });

    it('can search by original filename', function () {
        $target = VideoConversion::factory()->create(['original_filename' => 'my-video.mp4']);
        $other = VideoConversion::factory()->create(['original_filename' => 'other.mp4']);

        Livewire::test(ListVideoConversions::class)
            ->searchTable('my-video')
            ->assertCanSeeTableRecords([$target])
            ->assertCanNotSeeTableRecords([$other]);
    });
});

describe('Create page', function () {
    it('loads successfully', function () {
        Livewire::test(CreateVideoConversion::class)
            ->assertOk();
    });

    it('dispatches ConvertVideoJob after creation', function () {
        Queue::fake();
        Storage::fake('video_uploads');

        $conversion = VideoConversion::factory()->create();

        Queue::assertNothingPushed();

        ConvertVideoJob::dispatch($conversion);

        Queue::assertPushed(ConvertVideoJob::class, fn (ConvertVideoJob $job): bool => $job->videoConversion->is($conversion));
    });

    it('validates that target_size_mb is required', function () {
        Livewire::test(CreateVideoConversion::class)
            ->fillForm([
                'target_size_mb' => null,
            ])
            ->call('create')
            ->assertHasFormErrors(['target_size_mb' => 'required']);
    });

    it('validates that input_path is required', function () {
        Livewire::test(CreateVideoConversion::class)
            ->fillForm([
                'input_path' => null,
            ])
            ->call('create')
            ->assertHasFormErrors(['input_path' => 'required']);
    });
});

describe('View page', function () {
    it('loads successfully', function () {
        $conversion = VideoConversion::factory()->completed()->create();

        Livewire::test(ViewVideoConversion::class, ['record' => $conversion->id])
            ->assertOk();
    });

    it('displays the correct infolist state', function () {
        $conversion = VideoConversion::factory()->completed()->create();

        Livewire::test(ViewVideoConversion::class, ['record' => $conversion->id])
            ->assertOk()
            ->assertSchemaStateSet([
                'original_filename' => $conversion->original_filename,
                'status' => $conversion->status,
            ]);
    });

    it('shows error_message for failed conversions', function () {
        $failed = VideoConversion::factory()->failed()->create();

        Livewire::test(ViewVideoConversion::class, ['record' => $failed->id])
            ->assertSee($failed->error_message);
    });

    it('does not show error_message for completed conversions', function () {
        $conversion = VideoConversion::factory()->completed()->create();

        Livewire::test(ViewVideoConversion::class, ['record' => $conversion->id])
            ->assertOk()
            ->assertDontSee($conversion->error_message ?? 'should-not-appear');
    });
});
