<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class GettingStartedWidget extends Widget
{
    protected string $view = 'filament.widgets.getting-started-widget';

    protected int|string|array $columnSpan = 'full';

    public string $activeTab = 'how-to-use';
}
