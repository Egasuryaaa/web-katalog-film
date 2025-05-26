<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GenreResource\Pages;
use App\Filament\Resources\GenreResource\RelationManagers;
use App\Models\Genre;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;

class GenreResource extends Resource
{
    protected static ?string $model = Genre::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Menambahkan Schema untuk Form
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Genre Name')
                    ->required()
                    ->maxLength(255)
                    ->unique(Genre::class, 'name'), // Memastikan nama genre unik
            ]);
    }

    // Menambahkan kolom ke tabel
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Genre Name')
                    ->sortable()
                    ->searchable(), // Menampilkan nama genre
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                // Tombol Edit untuk tiap baris
                EditAction::make(),
            ])
            ->bulkActions([
                // Aksi untuk menghapus banyak data sekaligus
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Jika ada relasi lainnya yang perlu dikelola, tambahkan di sini
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGenres::route('/'),
            'create' => Pages\CreateGenre::route('/create'),
            'edit' => Pages\EditGenre::route('/{record}/edit'),
        ];
    }
}
