<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Filament\Resources\PostResource\Actions\GenerateArticleAction;
use App\Filament\Resources\PostResource\Actions\GenerateSeoAction;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            GenerateArticleAction::make('headerGenerateArticle')->label('AI: Tạo bài'),
            GenerateSeoAction::make('headerGenerateSeo')->label('AI: SEO'),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['ai_generated_image'])) {
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
