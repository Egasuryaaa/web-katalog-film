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
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Title'),

                Forms\Components\Textarea::make('description')
                    ->required()
                    ->label('Description'),

                Forms\Components\DatePicker::make('release_date')
                    ->required()
                    ->label('Release Date'),

                Forms\Components\TextInput::make('duration')
                    ->numeric()
                    ->required()
                    ->label('Duration (minutes)'),

                Forms\Components\TextInput::make('genre')
                    ->required()
                    ->maxLength(100)
                    ->label('Genre'),

                FileUpload::make('poster')
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('posters')
                    ->preserveFilenames()
                    ->maxSize(1024)
                    ->label('Poster Image'),

                Forms\Components\TextInput::make('trailer_url')
                    ->url()
                    ->nullable()
                    ->label('Trailer URL'),

                Forms\Components\TextInput::make('rating')
                    ->numeric()
                    ->nullable()
                    ->rules('min:0', 'max:10')
                    ->label('Rating'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->wrap()
                    ->tooltip(fn ($record) => $record->description)
                    ->extraAttributes([
                        'style' => 'white-space: normal; overflow-wrap: break-word;',
                    ]),
                Tables\Columns\TextColumn::make('release_date')
                    ->date()
                    ->label('Release Date')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration'),
                Tables\Columns\TextColumn::make('genre')
                    ->label('Genre')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('poster')
                    ->label('Poster')
                    ->disk('public')
                    ->height(80)
                    ->width(60),
                Tables\Columns\TextColumn::make('trailer_url')
                    ->label('Trailer URL')
                    ->limit(30)
                    ->url(fn ($record) => $record->trailer_url, true),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->numeric(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime('d-m-Y H:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime('d-m-Y H:i'),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
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

    public static function getRelations(): array
    {
        return [
            // Tambahkan relasi jika ada
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