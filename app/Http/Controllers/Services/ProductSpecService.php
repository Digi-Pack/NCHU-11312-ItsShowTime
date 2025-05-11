<?php

namespace App\Services;

use App\Models\Size;
use App\Models\Type;
use App\Models\Color;

class ProductSpecService
{
    public function syncProductSpecs(array $newItems, string $model): void
    {
        $keepIds = collect($newItems)->pluck('id')->filter()->toArray();
        $nameKey = $this->getNameKey($model);

        // 刪除不存在的資料
        $model::whereNotIn('id', $keepIds)->delete();

        foreach ($newItems as $item) {
            $record = $model::find($item['id']);

            if ($record) {
                $record->update([
                    $nameKey => $item[$nameKey],
                    'sort_order' => $item['sort'],
                ]);
            } else {
                $model::create([
                    'id' => $item['id'],
                    $nameKey => $item[$nameKey],
                    'sort_order' => $item['sort'],
                ]);
            }
        }
    }

    private function getNameKey(string $model): string
    {
        return match ($model) {
            Color::class => 'color_name',
            Type::class  => 'type_name',
            Size::class  => 'size_name',
        };
    }
}