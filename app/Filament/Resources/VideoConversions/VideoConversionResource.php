<?php

namespace App\Filament\Resources\VideoConversions;

use App\Filament\Resources\VideoConversions\Pages\CreateVideoConversion;
use App\Filament\Resources\VideoConversions\Pages\ListVideoConversions;
use App\Filament\Resources\VideoConversions\Pages\ViewVideoConversion;
use App\Filament\Resources\VideoConversions\Schemas\VideoConversionForm;
use App\Filament\Resources\VideoConversions\Schemas\VideoConversionInfolist;
use App\Filament\Resources\VideoConversions\Tables\VideoConversionsTable;
use App\Models\VideoConversion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VideoConversionResource extends Resource
{
    protected static ?string $model = VideoConversion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return VideoConversionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VideoConversionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VideoConversionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVideoConversions::route('/'),
            'create' => CreateVideoConversion::route('/create'),
            'view' => ViewVideoConversion::route('/{record}'),
        ];
    }
}
