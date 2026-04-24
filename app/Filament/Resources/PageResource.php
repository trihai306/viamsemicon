<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use UnitEnum;
use BackedEnum;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationLabel = 'Trang tĩnh';

    protected static ?string $modelLabel = 'Trang';

    protected static ?string $pluralModelLabel = 'Trang tĩnh';

    protected static string | UnitEnum | null $navigationGroup = 'Nội dung';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Thông tin chính')
                        ->schema([
                            Forms\Components\Select::make('template')
                                ->label('Template')
                                ->options([
                                    'default' => 'Mặc định',
                                    'about' => 'Giới thiệu',
                                    'contact' => 'Liên hệ',
                                    'policy' => 'Chính sách',
                                ])
                                ->required()
                                ->default('default'),

                            Forms\Components\TextInput::make('slug')
                                ->label('Slug')
                                ->unique(Page::class, 'slug', ignoreRecord: true)
                                ->maxLength(255),

                            Tabs::make('Translations')
                                ->tabs([
                                    Tabs\Tab::make('Tiếng Việt')
                                        ->schema([
                                            Forms\Components\TextInput::make('title.vi')
                                                ->label('Tiêu đề (VI)')
                                                ->required()
                                                ->maxLength(255),
                                            Forms\Components\RichEditor::make('content.vi')
                                                ->label('Nội dung (VI)')
                                                ->columnSpanFull(),
                                        ]),
                                    Tabs\Tab::make('English')
                                        ->schema([
                                            Forms\Components\TextInput::make('title.en')
                                                ->label('Title (EN)')
                                                ->maxLength(255),
                                            Forms\Components\RichEditor::make('content.en')
                                                ->label('Content (EN)')
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),

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
                Tables\Columns\TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->getStateUsing(fn (Page $record): string => $record->getTranslation('title', 'vi') ?: $record->getTranslation('title', 'en') ?: '')
                    ->searchable(query: function ($query, string $value) {
                        $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.vi')) LIKE ?", ["%{$value}%"])
                            ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.en')) LIKE ?", ["%{$value}%"]);
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('template')
                    ->label('Template')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'default' => 'Mặc định',
                        'about' => 'Giới thiệu',
                        'contact' => 'Liên hệ',
                        'policy' => 'Chính sách',
                        default => $state,
                    })
                    ->color('gray'),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Hiển thị'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('template')
                    ->label('Template')
                    ->options([
                        'default' => 'Mặc định',
                        'about' => 'Giới thiệu',
                        'contact' => 'Liên hệ',
                        'policy' => 'Chính sách',
                    ]),

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
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
