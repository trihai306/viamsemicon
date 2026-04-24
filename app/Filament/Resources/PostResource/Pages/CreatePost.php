<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Filament\Resources\PostResource\Actions\GenerateArticleAction;
use App\Filament\Resources\PostResource\Actions\GenerateSeoAction;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            GenerateArticleAction::make('headerGenerateArticle')->label('AI: Tạo bài'),
            GenerateSeoAction::make('headerGenerateSeo')->label('AI: SEO'),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['ai_generated_image']) && empty($data['image'])) {
            $data['image'] = $data['ai_generated_image'];
        }
        unset($data['ai_generated_image']);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
