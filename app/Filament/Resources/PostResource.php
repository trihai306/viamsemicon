<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Actions\EnhanceImageAction;
use App\Filament\Resources\PostResource\Actions\GenerateArticleAction;
use App\Filament\Resources\PostResource\Actions\GenerateImageAction;
use App\Filament\Resources\PostResource\Actions\GenerateSeoAction;
use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use UnitEnum;
use BackedEnum;
use Filament\Tables;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Bài viết';

    protected static ?string $modelLabel = 'Bài viết';

    protected static ?string $pluralModelLabel = 'Bài viết';

    protected static string | UnitEnum | null $navigationGroup = 'Nội dung';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([

            // AI Toolbar
            Actions::make([
                GenerateArticleAction::make(),
                GenerateSeoAction::make(),
                GenerateImageAction::make(),
                EnhanceImageAction::make(),
            ])->columnSpanFull(),

            // Main Content Tabs
            Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Thông tin chính')
                        ->icon('heroicon-o-pencil-square')
                        ->schema([
                            Forms\Components\Select::make('category_type')
                                ->label('Loại bài viết')
                                ->options([
                                    'tin-tuc' => 'Tin tức',
                                    'tuyen-dung' => 'Tuyển dụng',
                                ])
                                ->required(),

                            Forms\Components\TextInput::make('slug')
                                ->label('Slug')
                                ->unique(Post::class, 'slug', ignoreRecord: true)
                                ->maxLength(255)
                                ->helperText('Tự động tạo từ tiêu đề nếu để trống'),

                            Tabs::make('Translations')
                                ->tabs([
                                    Tabs\Tab::make('🇻🇳 Tiếng Việt')
                                        ->schema([
                                            Forms\Components\TextInput::make('title.vi')
                                                ->label('Tiêu đề (VI)')
                                                ->required()
                                                ->maxLength(255)
                                                ->placeholder('Nhập tiêu đề bài viết...'),

                                            Forms\Components\Textarea::make('excerpt.vi')
                                                ->label('Tóm tắt (VI)')
                                                ->rows(3)
                                                ->placeholder('Mô tả ngắn gọn nội dung bài viết (hiển thị trong danh sách)'),

                                            Forms\Components\RichEditor::make('content.vi')
                                                ->label('Nội dung (VI)')
                                                ->columnSpanFull()
                                                ->fileAttachmentsDirectory('posts/attachments')
                                                ->fileAttachmentsVisibility('public'),
                                        ]),
                                    Tabs\Tab::make('🇬🇧 English')
                                        ->schema([
                                            Forms\Components\TextInput::make('title.en')
                                                ->label('Title (EN)')
                                                ->maxLength(255),

                                            Forms\Components\Textarea::make('excerpt.en')
                                                ->label('Excerpt (EN)')
                                                ->rows(3),

                                            Forms\Components\RichEditor::make('content.en')
                                                ->label('Content (EN)')
                                                ->columnSpanFull()
                                                ->fileAttachmentsDirectory('posts/attachments')
                                                ->fileAttachmentsVisibility('public'),
                                        ]),
                                ])
                                ->columnSpanFull(),

                            Forms\Components\FileUpload::make('image')
                                ->label('Hình đại diện')
                                ->image()
                                ->directory('posts')
                                ->disk('public')
                                ->visibility('public')
                                ->imagePreviewHeight('200')
                                ->columnSpanFull(),

                            Forms\Components\Hidden::make('ai_generated_image'),

                            Forms\Components\Toggle::make('is_published')
                                ->label('Xuất bản')
                                ->default(false)
                                ->helperText('Bật để bài viết hiển thị trên website'),

                            Forms\Components\DateTimePicker::make('published_at')
                                ->label('Thời gian xuất bản')
                                ->default(now()),
                        ])
                        ->columns(2),

                    Tabs\Tab::make('SEO')
                        ->icon('heroicon-o-magnifying-glass')
                        ->schema([
                            Forms\Components\Placeholder::make('seo_hint')
                                ->content('💡 Tip: Sử dụng nút "Tạo SEO bằng AI" ở thanh công cụ phía trên để tự động tạo SEO từ nội dung bài viết.')
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

                Tables\Columns\TextColumn::make('title')
                    ->label('Tiêu đề')
                    ->getStateUsing(fn (Post $record): string => $record->getTranslation('title', 'vi') ?: $record->getTranslation('title', 'en') ?: '')
                    ->searchable(query: function ($query, string $value) {
                        $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.vi')) LIKE ?", ["%{$value}%"])
                            ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(title, '$.en')) LIKE ?", ["%{$value}%"]);
                    })
                    ->limit(50)
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('category_type')
                    ->label('Loại')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'tin-tuc' => 'Tin tức',
                        'tuyen-dung' => 'Tuyển dụng',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'tin-tuc' => 'info',
                        'tuyen-dung' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\ToggleColumn::make('is_published')
                    ->label('Xuất bản'),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Ngày đăng')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_type')
                    ->label('Loại bài viết')
                    ->options([
                        'tin-tuc' => 'Tin tức',
                        'tuyen-dung' => 'Tuyển dụng',
                    ]),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Trạng thái xuất bản'),
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
            ->defaultSort('published_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
