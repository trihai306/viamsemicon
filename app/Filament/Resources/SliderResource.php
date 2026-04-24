<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Models\Slider;
use Filament\Forms;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use UnitEnum;
use BackedEnum;
use Filament\Tables;
use Filament\Tables\Table;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Banner / Slider';

    protected static ?string $modelLabel = 'Slider';

    protected static ?string $pluralModelLabel = 'Banner / Slider';

    protected static string | UnitEnum | null $navigationGroup = 'Giao diện';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Tabs::make('Translations')
                ->tabs([
                    Tabs\Tab::make('Tiếng Việt')
                        ->schema([
                            Forms\Components\TextInput::make('title.vi')
                                ->label('Tiêu đề (VI)')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('subtitle.vi')
                                ->label('Tiêu đề phụ (VI)')
                                ->maxLength(255),
                        ]),
                    Tabs\Tab::make('English')
                        ->schema([
                            Forms\Components\TextInput::make('title.en')
                                ->label('Title (EN)')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('subtitle.en')
                                ->label('Subtitle (EN)')
                                ->maxLength(255),
                        ]),
                ])
                ->columnSpanFull(),

            Forms\Components\FileUpload::make('image')
                ->label('Hình ảnh')
                ->image()
                ->directory('sliders')
                ->required()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('link')
                ->label('Liên kết')
                ->url()
                ->maxLength(255),

            Forms\Components\TextInput::make('sort_order')
                ->label('Thứ tự')
                ->numeric()
                ->default(0),

            Forms\Components\Toggle::make('is_active')
                ->label('Hiển thị')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Hình')
                    ->disk('public')
                    ->size(80),

                Tables\Columns\TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->getStateUsing(fn (Slider $record): string => $record->getTranslation('title', 'vi') ?: $record->getTranslation('title', 'en') ?: '(Không có tiêu đề)')
                    ->searchable(query: function ($query, string $value) {
                        $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.vi')) LIKE ?", ["%{$value}%"])
                            ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.en')) LIKE ?", ["%{$value}%"]);
                    }),

                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Tiêu đề phụ')
                    ->getStateUsing(fn (Slider $record): string => $record->getTranslation('subtitle', 'vi') ?: $record->getTranslation('subtitle', 'en') ?: ''),

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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
