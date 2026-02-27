<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Welcome to Video Converter
        </x-slot>

        <x-slot name="description">
            A quick guide to convert videos and run the app reliably.
        </x-slot>

        <x-filament::tabs label="Dashboard guide tabs">
            <x-filament::tabs.item
                :active="$activeTab === 'how-to-use'"
                wire:click="$set('activeTab', 'how-to-use')"
                icon="heroicon-o-play-circle"
            >
                How to Use
            </x-filament::tabs.item>

            <x-filament::tabs.item
                :active="$activeTab === 'getting-started'"
                wire:click="$set('activeTab', 'getting-started')"
                icon="heroicon-o-wrench-screwdriver"
            >
                Getting Started
            </x-filament::tabs.item>
        </x-filament::tabs>

        <div class="mt-6">
            @if ($activeTab === 'how-to-use')
                <div class="space-y-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Follow these 4 steps to compress videos to a target size and download the result.
                    </p>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-white/5 dark:bg-white/5 dark:shadow-none">
                            <div class="flex items-start gap-4">
                                <div class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400">
                                    <x-filament::icon icon="heroicon-o-arrow-up-tray" class="size-5" />
                                </div>
                                <div>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Step 1</span>
                                    <h3 class="text-sm font-semibold text-gray-950 dark:text-white">Upload a video</h3>
                                </div>
                            </div>
                            <p class="mt-4 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                                Open <strong>Video Conversions</strong> and click <strong>New video conversion</strong>. Supported formats: MP4, MOV, AVI, MKV, and WebM (up to 2 GB).
                            </p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-white/5 dark:bg-white/5 dark:shadow-none">
                            <div class="flex items-start gap-4">
                                <div class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400">
                                    <x-filament::icon icon="heroicon-o-arrows-pointing-in" class="size-5" />
                                </div>
                                <div>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Step 2</span>
                                    <h3 class="text-sm font-semibold text-gray-950 dark:text-white">Set target size</h3>
                                </div>
                            </div>
                            <p class="mt-4 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                                Enter your desired output size in MB. Optionally tune audio bitrate (default: 128 kbps).
                            </p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-white/5 dark:bg-white/5 dark:shadow-none">
                            <div class="flex items-start gap-4">
                                <div class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400">
                                    <x-filament::icon icon="heroicon-o-arrow-path" class="size-5" />
                                </div>
                                <div>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Step 3</span>
                                    <h3 class="text-sm font-semibold text-gray-950 dark:text-white">Wait for processing</h3>
                                </div>
                            </div>
                            <p class="mt-4 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                                Conversion runs in the queue. Track status as <strong>Processing</strong>, <strong>Completed</strong>, or <strong>Failed</strong>.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-white/5 dark:bg-white/5 dark:shadow-none">
                            <div class="flex items-start gap-4">
                                <div class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400">
                                    <x-filament::icon icon="heroicon-o-arrow-down-tray" class="size-5" />
                                </div>
                                <div>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Step 4</span>
                                    <h3 class="text-sm font-semibold text-gray-950 dark:text-white">Download result</h3>
                                </div>
                            </div>
                            <p class="mt-4 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                                Open the completed record to see final size, duration, and bitrate details, then download the converted file.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <x-filament::button
                            :href="App\Filament\Resources\VideoConversions\VideoConversionResource::getUrl('create')"
                            icon="heroicon-m-arrow-right"
                            icon-position="after"
                            tag="a"
                        >
                            Start your first conversion
                        </x-filament::button>
                        <x-filament::button
                            :href="App\Filament\Resources\VideoConversions\VideoConversionResource::getUrl('index')"
                            icon="heroicon-o-folder"
                            color="gray"
                            tag="a"
                        >
                            View all conversions
                        </x-filament::button>
                    </div>
                </div>
            @else
                <div
                    class="space-y-4"
                    x-data="{
                        copiedCommand: null,
                        async copyCommand(command) {
                            try {
                                if (navigator.clipboard && window.isSecureContext) {
                                    await navigator.clipboard.writeText(command);
                                } else {
                                    const textarea = document.createElement('textarea');
                                    textarea.value = command;
                                    textarea.setAttribute('readonly', '');
                                    textarea.style.position = 'absolute';
                                    textarea.style.left = '-9999px';
                                    document.body.appendChild(textarea);
                                    textarea.select();
                                    document.execCommand('copy');
                                    document.body.removeChild(textarea);
                                }

                                this.copiedCommand = command;

                                setTimeout(() => {
                                    if (this.copiedCommand === command) {
                                        this.copiedCommand = null;
                                    }
                                }, 1500);
                            } catch (error) {
                                console.error(error);
                            }
                        }
                    }"
                >
                    {{-- Prerequisites --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-white/5 dark:bg-white/5 dark:shadow-none">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex size-8 shrink-0 items-center justify-center rounded bg-primary-100 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400">
                                <x-filament::icon icon="heroicon-o-server-stack" class="size-4" />
                            </div>
                            <h3 class="text-base font-semibold text-gray-950 dark:text-white">Prerequisites</h3>
                        </div>
                        <div class="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-950 dark:text-white">PHP 8.5</span>
                                <span class="text-gray-500">via <a href="https://herd.laravel.com" target="_blank" class="text-primary-600 hover:underline dark:text-primary-400">Laravel Herd</a></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-950 dark:text-white">FFMpeg</span>
                                <code class="text-gray-500">brew install ffmpeg</code>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-950 dark:text-white">Composer</span>
                                <code class="text-gray-500">composer install</code>
                            </div>
                        </div>
                    </div>

                    {{-- First-time setup --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-white/5 dark:bg-white/5 dark:shadow-none">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex size-8 shrink-0 items-center justify-center rounded bg-primary-100 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400">
                                <x-filament::icon icon="heroicon-o-command-line" class="size-4" />
                            </div>
                            <h3 class="text-base font-semibold text-gray-950 dark:text-white">First-time setup</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 dark:border-white/5 dark:bg-white/5">
                                <div class="flex items-center gap-3 font-mono text-sm text-gray-800 dark:text-gray-300">
                                    <span class="text-primary-600 dark:text-primary-400">&gt;_</span>
                                    <span>php artisan migrate</span>
                                </div>
                                <button
                                    type="button"
                                    class="rounded p-1 text-gray-400 transition hover:text-primary-600 dark:hover:text-primary-400"
                                    @click="copyCommand('php artisan migrate')"
                                    aria-label="Copy php artisan migrate command"
                                    title="Copy command"
                                >
                                    <x-filament::icon
                                        icon="heroicon-o-document-duplicate"
                                        class="size-4"
                                        x-show="copiedCommand !== 'php artisan migrate'"
                                    />
                                    <x-filament::icon
                                        icon="heroicon-o-check"
                                        class="size-4 text-success-600 dark:text-success-400"
                                        x-show="copiedCommand === 'php artisan migrate'"
                                    />
                                </button>
                            </div>
                            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 dark:border-white/5 dark:bg-white/5">
                                <div class="flex items-center gap-3 font-mono text-sm text-gray-800 dark:text-gray-300">
                                    <span class="text-primary-600 dark:text-primary-400">&gt;_</span>
                                    <span>php artisan make:filament-user</span>
                                </div>
                                <button
                                    type="button"
                                    class="rounded p-1 text-gray-400 transition hover:text-primary-600 dark:hover:text-primary-400"
                                    @click="copyCommand('php artisan make:filament-user')"
                                    aria-label="Copy php artisan make:filament-user command"
                                    title="Copy command"
                                >
                                    <x-filament::icon
                                        icon="heroicon-o-document-duplicate"
                                        class="size-4"
                                        x-show="copiedCommand !== 'php artisan make:filament-user'"
                                    />
                                    <x-filament::icon
                                        icon="heroicon-o-check"
                                        class="size-4 text-success-600 dark:text-success-400"
                                        x-show="copiedCommand === 'php artisan make:filament-user'"
                                    />
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Queue Worker --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-white/5 dark:bg-white/5 dark:shadow-none">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex size-8 shrink-0 items-center justify-center rounded bg-primary-100 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400">
                                <x-filament::icon icon="heroicon-o-arrow-path" class="size-4" />
                            </div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-base font-semibold text-gray-950 dark:text-white">Queue worker</h3>
                                <x-filament::badge color="danger" size="sm">Required</x-filament::badge>
                            </div>
                        </div>
                        <p class="mb-4 text-sm text-gray-600 dark:text-gray-300">Keep this command running in a terminal for conversions to process:</p>
                        <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 dark:border-white/5 dark:bg-white/5">
                            <div class="flex items-center gap-3 font-mono text-sm text-gray-800 dark:text-gray-300">
                                <span class="text-primary-600 dark:text-primary-400">&gt;_</span>
                                <span>php artisan queue:work --timeout=3600 --memory=512</span>
                            </div>
                            <button
                                type="button"
                                class="rounded p-1 text-gray-400 transition hover:text-primary-600 dark:hover:text-primary-400"
                                @click="copyCommand('php artisan queue:work --timeout=3600 --memory=512')"
                                aria-label="Copy php artisan queue:work command"
                                title="Copy command"
                            >
                                <x-filament::icon
                                    icon="heroicon-o-document-duplicate"
                                    class="size-4"
                                    x-show="copiedCommand !== 'php artisan queue:work --timeout=3600 --memory=512'"
                                />
                                <x-filament::icon
                                    icon="heroicon-o-check"
                                    class="size-4 text-success-600 dark:text-success-400"
                                    x-show="copiedCommand === 'php artisan queue:work --timeout=3600 --memory=512'"
                                />
                            </button>
                        </div>
                    </div>

                    <div class="grid gap-4 lg:grid-cols-2">
                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-white/5 dark:bg-white/5 dark:shadow-none">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="flex size-8 shrink-0 items-center justify-center rounded bg-primary-100 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400">
                                    <x-filament::icon icon="heroicon-o-cog-8-tooth" class="size-4" />
                                </div>
                                <h3 class="text-base font-semibold text-gray-950 dark:text-white">Environment variables</h3>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 dark:border-white/5 dark:bg-white/5">
                                    <div class="flex items-center gap-3 font-mono text-sm text-gray-800 dark:text-gray-300 overflow-x-auto whitespace-nowrap scrollbar-hide">
                                        <span>QUEUE_CONNECTION=database</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 dark:border-white/5 dark:bg-white/5">
                                    <div class="flex items-center gap-3 font-mono text-sm text-gray-800 dark:text-gray-300 overflow-x-auto whitespace-nowrap scrollbar-hide">
                                        <span>FFMPEG_BINARIES=/usr/local/bin/ffmpeg</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 dark:border-white/5 dark:bg-white/5">
                                    <div class="flex items-center gap-3 font-mono text-sm text-gray-800 dark:text-gray-300 overflow-x-auto whitespace-nowrap scrollbar-hide">
                                        <span>FFPROBE_BINARIES=/usr/local/bin/ffprobe</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-white/5 dark:bg-white/5 dark:shadow-none">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="flex size-8 shrink-0 items-center justify-center rounded bg-primary-100 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400">
                                    <x-filament::icon icon="heroicon-o-arrows-up-down" class="size-4" />
                                </div>
                                <h3 class="text-base font-semibold text-gray-950 dark:text-white">Upload limits</h3>
                            </div>
                            <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-white/5">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-gray-50 text-gray-700 dark:bg-white/5 dark:text-gray-300">
                                        <tr>
                                            <th class="px-4 py-3 font-medium">Layer</th>
                                            <th class="px-4 py-3 font-medium">Limit</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 text-gray-600 dark:divide-white/5 dark:text-gray-300 bg-white dark:bg-white/5">
                                        <tr>
                                            <td class="px-4 py-3">Nginx</td>
                                            <td class="px-4 py-3">2048 MB</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3">PHP upload_max_filesize</td>
                                            <td class="px-4 py-3">2 GB</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3">PHP post_max_size</td>
                                            <td class="px-4 py-3">2 GB</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3">Livewire temporary upload</td>
                                            <td class="px-4 py-3">2 GB</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
