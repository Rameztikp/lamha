<?php

namespace App\Filament\Resources\HotelResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChaletsRelationManager extends RelationManager
{
    protected static string $relationship = 'chalets';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('price_per_night')
                    ->required()
                    ->numeric()
                    ->prefix('ريال'),
                Forms\Components\TextInput::make('capacity')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                Forms\Components\TextInput::make('room_size')
                    ->numeric()
                    ->suffix('م²'),
                Forms\Components\TextInput::make('beds')
                    ->numeric()
                    ->minValue(1),
                Forms\Components\TextInput::make('bathrooms')
                    ->numeric()
                    ->minValue(1),
                Forms\Components\Toggle::make('has_breakfast')
                    ->label('يشمل الإفطار'),
                Forms\Components\Toggle::make('is_available')
                    ->label('متاح')
                    ->default(true),
                Forms\Components\TextInput::make('max_adults')
                    ->numeric()
                    ->minValue(1),
                Forms\Components\TextInput::make('max_children')
                    ->numeric()
                    ->minValue(0),
                Forms\Components\TagsInput::make('amenities')
                    ->label('المرافق')
                    ->placeholder('أضف مرفقاً'),
                Forms\Components\FileUpload::make('main_image')
                    ->image()
                    ->directory('chalets')
                    ->nullable(),
                Forms\Components\FileUpload::make('gallery')
                    ->image()
                    ->multiple()
                    ->directory('chalets/gallery')
                    ->nullable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('price_per_night')
                    ->money('SAR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('capacity'),
                Tables\Columns\IconColumn::make('is_available')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_breakfast')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
