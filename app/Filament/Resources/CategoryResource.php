<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use UnitEnum;
use BackedEnum;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Danh mục';

    protected static ?string $modelLabel = 'Danh mục';

    protected static ?string $pluralModelLabel = 'Danh mục';

    protected static string | UnitEnum | null $navigationGroup = 'Sản phẩm';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Thông tin chính')
                        ->schema([
                            Tabs::make('Translations')
                                ->tabs([
                                    Tabs\Tab::make('Tiếng Việt')
                                        ->schema([
                                            Forms\Components\TextInput::make('name.vi')
                                                ->label('Tên (VI)')
                                                ->required()
                                                ->maxLength(255),
                                            Forms\Components\RichEditor::make('description.vi')
                                                ->label('Mô tả (VI)')
                                                ->columnSpanFull(),
                                        ]),
                                    Tabs\Tab::make('English')
                                        ->schema([
                                            Forms\Components\TextInput::make('name.en')
                                                ->label('Name (EN)')
                                                ->maxLength(255),
                                            Forms\Components\RichEditor::make('description.en')
                                                ->label('Description (EN)')
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),

                            Forms\Components\TextInput::make('slug')
                                ->label('Slug')
                                ->unique(Category::class, 'slug', ignoreRecord: true)
                                ->maxLength(255),

                            Forms\Components\Select::make('parent_id')
                                ->label('Danh mục cha')
                                ->options(function (?Category $record) {
                                    $query = Category::query();
                                    if ($record) {
                                        $query->where('id', '!=', $record->id);
                                    }
                                    return $query->pluck('name', 'id')
                                        ->map(fn ($name) => is_array($name) ? ($name['vi'] ?? $name['en'] ?? '') : $name);
                                })
                                ->searchable()
                                ->placeholder('Không có (danh mục gốc)'),

                            Forms\Components\FileUpload::make('image')
                                ->label('Hình ảnh')
                                ->image()
                                ->directory('categories')
                                ->columnSpanFull(),

                            Forms\Components\TextInput::make('sort_order')
                                ->label('Thứ tự')
                                ->numeric()
                                ->default(0),

                            Forms\Components\Toggle::make('is_active')
                                ->label('Hiển thị')
                                ->default(true),
                        ])
                        ->columns(2),

                    Tabs\Tab::make('SEO')
                        ->schema([
                            Tabs::make('SEO Translations')
                                ->tabs([
                                    Tabs\Tab::make('Tiếng Việt')
                                        ->schema([
                                            Forms\Components\TextInput::make('seo_title.vi')
                                                ->label('SEO Title (VI)')
                                                ->maxLength(255),
                                            Forms\Components\Textarea::make('seo_description.vi')
                                                ->label('SEO Description (VI)')
                                                ->rows(3),
                                        ]),
                                    Tabs\Tab::make('English')
                                        ->schema([
                                            Forms\Components\TextInput::make('seo_title.en')
                                                ->label('SEO Title (EN)')
                                                ->maxLength(255),
                                            Forms\Components\Textarea::make('seo_description.en')
                                                ->label('SEO Description (EN)')
                                                ->rows(3),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ]),
                ])
                ->columnSpanFull(),
        ]);
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

                Tables\Columns\TextColumn::make('name')
                    ->label('Tên')
                    ->getStateUsing(fn (Category $record): string => $record->getTranslation('name', 'vi') ?: $record->getTranslation('name', 'en') ?: '')
                    ->searchable(query: function ($query, string $value) {
                        $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.vi')) LIKE ?", ["%{$value}%"])
                            ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.en')) LIKE ?", ["%{$value}%"]);
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('products_count')
                    ->label('Sản phẩm')
                    ->counts('products')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Thứ tự')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Hiển thị'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Trạng thái hiển thị'),
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
            ->defaultSort('sort_order');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
