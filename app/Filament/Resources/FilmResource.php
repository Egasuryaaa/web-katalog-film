<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FilmResource\Pages;
use App\Models\Film;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;

class FilmResource extends Resource
{
    protected static ?string $model = Film::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Title field
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Title'),

                // Description field
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->label('Description'),

                // Release Date field
                Forms\Components\DatePicker::make('release_date')
                    ->required()
                    ->label('Release Date'),

                // Duration field (in minutes)
                Forms\Components\TextInput::make('duration')
                    ->numeric()
                    ->required()
                    ->label('Duration (minutes)'),

                // Genre field
                Forms\Components\TextInput::make('genre')
                    ->required()
                    ->maxLength(100)
                    ->label('Genre'),

                // Poster Image field (File upload)
                FileUpload::make('poster')
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('posters') // Directory for storing the poster images
                    ->preserveFilenames()
                    ->maxSize(1024)
                    ->label('Poster Image'),

                // Trailer URL field (URL input)
                Forms\Components\TextInput::make('trailer_url')
                    ->url()
                    ->nullable()
                    ->label('Trailer URL'),

                // Rating field
                Forms\Components\TextInput::make('rating')
                    ->numeric()
                    ->nullable()
                    ->rules('min:0', 'max:10') // Use validation rules for min/max
                    ->label('Rating'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description'),
                Tables\Columns\TextColumn::make('release_date')
                    ->date()
                    ->label('Release Date')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration'),
                Tables\Columns\TextColumn::make('genre')
                    ->label('Genre'),
                Tables\Columns\ImageColumn::make('poster')
                    ->label('Poster')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('trailer_url')
                    ->label('Trailer URL'),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->numeric(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add any filters if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Add relations if you have any
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFilms::route('/'),
            'create' => Pages\CreateFilm::route('/create'),
            'edit' => Pages\EditFilm::route('/{record}/edit'),
        ];
    }
}
