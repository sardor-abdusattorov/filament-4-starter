<?php

namespace App\Filament\Resources\SiteTranslations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SiteTranslationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('category'),
                TextInput::make('key')
                    ->required(),
                TextInput::make('value')
                    ->required(),
                Toggle::make('is_published')
                    ->required(),
            ]);
    }
}
