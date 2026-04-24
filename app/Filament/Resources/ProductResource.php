<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Actions\GenerateProductDescAction;
use App\Filament\Resources\ProductResource\Actions\GenerateProductImageAction;
use App\Filament\Resources\ProductResource\Actions\GenerateProductSeoAction;
use App\Filament\Resources\ProductResource\Actions\GenerateProductSpecsAction;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use UnitEnum;
use BackedEnum;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationLabel = 'Sản phẩm';

    protected static ?string $modelLabel = 'Sản phẩm';

    protected static ?string $pluralModelLabel = 'Sản phẩm';

    protected static string | UnitEnum | null $navigationGroup = 'Sản phẩm';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([

            // AI Toolbar
            Actions::make([
                GenerateProductDescAction::make(),
                GenerateProductSpecsAction::make(),
                GenerateProductSeoAction::make(),
                GenerateProductImageAction::make(),
            ])->columnSpanFull(),

            // Main Tabs
            Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Thông tin chính')
                        ->icon('heroicon-o-pencil-square')
                        ->schema([
                            Forms\Components\Select::make('category_id')
                                ->label('Danh mục')
                                ->options(
                                    Category::all()->pluck('name', 'id')
                                        ->map(fn ($name) => is_array($name) ? ($name['vi'] ?? $name['en'] ?? '') : $name)
                                )
                                ->searchable()
                                ->required(),

                            Forms\Components\TextInput::make('slug')
                                ->label('Slug')
                                ->unique(Product::class, 'slug', ignoreRecord: true)
                                ->maxLength(255)
                                ->helperText('Tự động tạo từ tên sản phẩm'),

                            Tabs::make('Translations')
                                ->tabs([
                                    Tabs\Tab::make('🇻🇳 Tiếng Việt')
                                        ->schema([
                                            Forms\Components\TextInput::make('name.vi')
                                                ->label('Tên sản phẩm (VI)')
                                                ->required()
                                                ->maxLength(255)
                                                ->placeholder('VD: Máy phân tích phổ Keysight N9010B'),
                                            Forms\Components\Textarea::make('short_description.vi')
                                                ->label('Mô tả ngắn (VI)')
                                                ->rows(3)
                                                ->placeholder('Mô tả ngắn gọn hiển thị trong danh sách sản phẩm'),
                                            Forms\Components\RichEditor::make('description.vi')
                                                ->label('Mô tả chi tiết (VI)')
                                                ->columnSpanFull()
                                                ->fileAttachmentsDirectory('products/attachments'),
                                        ]),
                                    Tabs\Tab::make('🇬🇧 English')
                                        ->schema([
                                            Forms\Components\TextInput::make('name.en')
                                                ->label('Product Name (EN)')
                                                ->maxLength(255),
                                            Forms\Components\Textarea::make('short_description.en')
                                                ->label('Short Description (EN)')
                                                ->rows(3),
                                            Forms\Components\RichEditor::make('description.en')
                                                ->label('Description (EN)')
                                                ->columnSpanFull()
                                                ->fileAttachmentsDirectory('products/attachments'),
                                        ]),
                                ])
                                ->columnSpanFull(),

                            Forms\Components\TextInput::make('price')
                                ->label('Giá')
                                ->numeric()
                                ->prefix('VNĐ'),

                            Forms\Components\TextInput::make('price_text')
                                ->label('Giá hiển thị')
                                ->placeholder('VD: Liên hệ, 1.500.000đ')
                                ->maxLength(255),

                            Forms\Components\TextInput::make('sort_order')
                                ->label('Thứ tự')
                                ->numeric()
                                ->default(0),

                            Forms\Components\Toggle::make('is_featured')
                                ->label('Nổi bật')
                                ->default(false),

                            Forms\Components\Toggle::make('is_active')
                                ->label('Hiển thị')
                                ->default(true),
                        ])
                        ->columns(2),

                    Tabs\Tab::make('Hình ảnh')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            Forms\Components\FileUpload::make('image')
                                ->label('Hình đại diện')
                                ->image()
                                ->directory('products')
                                ->disk('public')
                                ->visibility('public')
                                ->imagePreviewHeight('200')
                                ->columnSpanFull(),

                            Forms\Components\FileUpload::make('gallery')
                                ->label('Thư viện ảnh')
                                ->image()
                                ->multiple()
                                ->reorderable()
                                ->directory('products/gallery')
                                ->disk('public')
                                ->visibility('public')
                                ->columnSpanFull(),

                            Forms\Components\Hidden::make('ai_generated_image'),
                        ]),

                    Tabs\Tab::make('Thông số kỹ thuật')
                        ->icon('heroicon-o-cpu-chip')
                        ->schema([
                            Forms\Components\Placeholder::make('specs_hint')
                                ->content('💡 Tip: Dùng nút "Tạo thông số AI" ở toolbar phía trên để tự động tạo thông số kỹ thuật.')
                                ->columnSpanFull(),

                            Forms\Components\KeyValue::make('specifications')
                                ->label('Thông số')
                                ->keyLabel('Thông số')
                                ->valueLabel('Giá trị')
                                ->columnSpanFull(),
                        ]),

                    Tabs\Tab::make('SEO')
                        ->icon('heroicon-o-magnifying-glass')
                        ->schema([
                            Forms\Components\Placeholder::make('seo_hint')
                                ->content('💡 Tip: Dùng nút "Tạo SEO AI" ở toolbar phía trên để tự động tạo SEO.')
                                ->columnSpanFull(),

                            Tabs::make('SEO Translations')
                                ->tabs([
                                    Tabs\Tab::make('🇻🇳 Tiếng Việt')
                                        ->schema([
                                            Forms\Components\TextInput::make('seo_title.vi')
                                                ->label('SEO Title (VI)')
                                                ->maxLength(255)
                                                ->helperText('Tối ưu 50-60 ký tự'),
                                            Forms\Components\Textarea::make('seo_description.vi')
                                                ->label('SEO Description (VI)')
                                                ->rows(3)
                                                ->maxLength(500)
                                                ->helperText('Tối ưu 150-160 ký tự'),
                                        ]),
                                    Tabs\Tab::make('🇬🇧 English')
                                        ->schema([
                                            Forms\Components\TextInput::make('seo_title.en')
                                                ->label('SEO Title (EN)')
                                                ->maxLength(255),
                                            Forms\Components\Textarea::make('seo_description.en')
                                                ->label('SEO Description (EN)')
                                                ->rows(3)
                                                ->maxLength(500),
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
                    ->label('Tên sản phẩm')
                    ->getStateUsing(fn (Product $record): string => $record->getTranslation('name', 'vi') ?: $record->getTranslation('name', 'en') ?: '')
                    ->searchable(query: function ($query, string $value) {
                        $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.vi')) LIKE ?", ["%{$value}%"])
                            ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.en')) LIKE ?", ["%{$value}%"]);
                    })
                    ->limit(40)
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Danh mục')
                    ->getStateUsing(fn (Product $record): string => $record->category
                        ? ($record->category->getTranslation('name', 'vi') ?: $record->category->getTranslation('name', 'en') ?: '')
                        : '')
                    ->sortable(),

                Tables\Columns\TextColumn::make('price_text')
                    ->label('Giá')
                    ->default('Liên hệ'),

                Tables\Columns\ToggleColumn::make('is_featured')
                    ->label('Nổi bật'),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Hiển thị'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Danh mục')
                    ->options(
                        Category::all()->pluck('name', 'id')
                            ->map(fn ($name) => is_array($name) ? ($name['vi'] ?? $name['en'] ?? '') : $name)
                    ),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Nổi bật'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Hiển thị'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
