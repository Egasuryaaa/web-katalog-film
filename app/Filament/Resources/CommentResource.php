<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationGroup = 'Comments';
    
    protected static ?string $navigationLabel = 'Comments';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(255),
            
            TextInput::make('email')
                ->label('Email')
                ->required()
                ->maxLength(255),

            Textarea::make('comment')
                ->label('Comment')
                ->required()
                ->maxLength(1000),

            Select::make('parent_id')
                ->label('Reply To')
                ->options(function () {
                    // Ambil semua komentar utama (tanpa parent_id)
                    return Comment::whereNull('parent_id')->pluck('comment', 'id');
                })
                ->nullable()
                ->searchable()
                ->hint('Reply to another comment')
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('email')
                    ->label('Email')
                    ->sortable(),

                TextColumn::make('comment')
                    ->label('Comment')
                    ->sortable()
                    ->limit(50),
                
                BadgeColumn::make('parent_id')
                    ->label('Reply To')
                    ->getStateUsing(function ($record) {
                        return $record->parent_id ? 'Reply to Comment #' . $record->parent_id : 'No Parent';
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}

