<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeatureResource\Pages;
use App\Models\Feature;
use Filament\Forms;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use UnitEnum;
use BackedEnum;
use Filament\Tables;
use Filament\Tables\Table;

class FeatureResource extends Resource
{
    protected static ?string $model = Feature::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Tính năng nổi bật';

    protected static ?string $modelLabel = 'Tính năng';

    protected static ?string $pluralModelLabel = 'Tính năng nổi bật';

    protected static string | UnitEnum | null $navigationGroup = 'Giao diện';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Tabs::make('Translations')
                ->tabs([
                    Tabs\Tab::make('Tiếng Việt')
                        ->schema([
                            Forms\Components\TextInput::make('title.vi')
                                ->label('Tiêu đề (VI)')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Textarea::make('description.vi')
                                ->label('Mô tả (VI)')
                                ->rows(3),
                        ]),
                    Tabs\Tab::make('English')
                        ->schema([
                            Forms\Components\TextInput::make('title.en')
                                ->label('Title (EN)')
                                ->maxLength(255),
                            Forms\Components\Textarea::make('description.en')
                                ->label('Description (EN)')
                                ->rows(3),
                        ]),
                ])
                ->columnSpanFull(),

            Forms\Components\TextInput::make('icon')
                ->label('Icon (CSS class hoặc SVG)')
                ->placeholder('VD: heroicon-star, fa-star')
                ->maxLength(255),

            Forms\Components\FileUpload::make('image')
                ->label('Hình ảnh')
                ->image()
                ->directory('features')
                ->columnSpanFull(),

            Forms\Components\TextInput::make('sort_order')
                ->label('Thứ tự')
                ->numeric()
                ->default(0),

            Forms\Components\Toggle::make('is_active')
                ->label('Hiển thị')
                ->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Hình')
                    ->disk('public')
                    ->square()
                    ->size(50),

                Tables\Columns\TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->getStateUsing(fn (Feature $record): string => $record->getTranslation('title', 'vi') ?: $record->getTranslation('title', 'en') ?: '')
                    ->searchable(query: function ($query, string $value) {
                        $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.vi')) LIKE ?", ["%{$value}%"])
                            ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.en')) LIKE ?", ["%{$value}%"]);
                    }),

                Tables\Columns\TextColumn::make('description')
                    ->label('Mô tả')
                    ->getStateUsing(fn (Feature $record): string => $record->getTranslation('description', 'vi') ?: $record->getTranslation('description', 'en') ?: '')
                    ->limit(60),

                Tables\Columns\TextColumn::make('icon')
                    ->label('Icon'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Thứ tự')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Hiển thị'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Trạng thái'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeatures::route('/'),
            'create' => Pages\CreateFeature::route('/create'),
            'edit' => Pages\EditFeature::route('/{record}/edit'),
        ];
    }
}
