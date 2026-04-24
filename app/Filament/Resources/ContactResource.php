<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use UnitEnum;
use BackedEnum;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Schemas\Schema as InfolistSchema;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Liên hệ';

    protected static ?string $modelLabel = 'Liên hệ';

    protected static ?string $pluralModelLabel = 'Liên hệ';

    protected static string | UnitEnum | null $navigationGroup = 'Hệ thống';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return (string) Contact::where('is_read', false)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('name')->label('Họ tên')->disabled(),
            Forms\Components\TextInput::make('email')->label('Email')->disabled(),
            Forms\Components\TextInput::make('phone')->label('Số điện thoại')->disabled(),
            Forms\Components\TextInput::make('subject')->label('Chủ đề')->disabled()->columnSpanFull(),
            Forms\Components\Textarea::make('message')->label('Nội dung')->disabled()->rows(5)->columnSpanFull(),
            Forms\Components\Toggle::make('is_read')->label('Đã đọc'),
        ])->columns(2);
    }

    public static function infolist(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema->schema([
            Infolists\Components\Section::make('Thông tin liên hệ')
                ->schema([
                    Infolists\Components\Grid::make(2)
                        ->schema([
                            Infolists\Components\TextEntry::make('name')
                                ->label('Họ tên'),
                            Infolists\Components\TextEntry::make('email')
                                ->label('Email')
                                ->copyable(),
                            Infolists\Components\TextEntry::make('phone')
                                ->label('Số điện thoại')
                                ->copyable(),
                            Infolists\Components\TextEntry::make('subject')
                                ->label('Chủ đề'),
                        ]),

                    Infolists\Components\TextEntry::make('message')
                        ->label('Nội dung')
                        ->columnSpanFull(),

                    Infolists\Components\Grid::make(2)
                        ->schema([
                            Infolists\Components\IconEntry::make('is_read')
                                ->label('Trạng thái')
                                ->boolean()
                                ->trueLabel('Đã đọc')
                                ->falseLabel('Chưa đọc'),
                            Infolists\Components\TextEntry::make('created_at')
                                ->label('Thời gian gửi')
                                ->dateTime('d/m/Y H:i'),
                        ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Họ tên')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Điện thoại')
                    ->searchable(),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Chủ đề')
                    ->limit(40),

                Tables\Columns\BadgeColumn::make('is_read')
                    ->label('Trạng thái')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Đã đọc' : 'Chưa đọc')
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày gửi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('Trạng thái đọc')
                    ->trueLabel('Đã đọc')
                    ->falseLabel('Chưa đọc'),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\Action::make('mark_read')
                    ->label('Đánh dấu đã đọc')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Contact $record): bool => ! $record->is_read)
                    ->action(fn (Contact $record) => $record->update(['is_read' => true]))
                    ->requiresConfirmation(false),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('mark_all_read')
                        ->label('Đánh dấu đã đọc')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn ($records) => $records->each->update(['is_read' => true])),
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'view' => Pages\ViewContact::route('/{record}'),
        ];
    }
}
