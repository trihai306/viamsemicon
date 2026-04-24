<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Filament\Resources\ProductResource\Actions\GenerateProductDescAction;
use App\Filament\Resources\ProductResource\Actions\GenerateProductSeoAction;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            GenerateProductDescAction::make('headerGenDesc')->label('AI: Mô tả'),
            GenerateProductSeoAction::make('headerGenSeo')->label('AI: SEO'),
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
