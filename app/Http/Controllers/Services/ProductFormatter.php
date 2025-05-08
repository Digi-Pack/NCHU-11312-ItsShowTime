<?php

namespace App\Services;

class ProductFormatter
{
    public static function format($product)
    {
        $colors = $product->productsInfo
            ->filter(fn($info) => $info->color_id !== null && $info->color !== null)
            ->map(fn($info) => [
                'id' => $info->color_id,
                'name' => $info->color->color_name,
            ])
            ->unique('id')
            ->values();

        $sizes = $product->productsInfo
            ->filter(fn($info) => $info->size_id !== null && $info->size !== null)
            ->map(fn($info) => [
                'id' => $info->size_id,
                'name' => $info->size->size_name,
            ])
            ->unique('id')
            ->values();

        $types = $product->productsInfo
            ->filter(fn($info) => $info->type_id !== null && $info->type !== null)
            ->map(fn($info) => [
                'id' => $info->type_id,
                'name' => $info->type->type_name,
            ])
            ->unique('id')
            ->values();

        $images = $product->productsInfo
            ->filter(fn($info) => $info->image_id !== null && $info->image !== null)
            ->map(fn($info) => [
                'id' => $info->image_id,
                'img_path' => $info->image->img_path,
                'isMain' => $info->image->isMain,
            ])
            ->unique('id')
            ->values();

        $first_img = $images->first(fn($image) => $image['isMain'] === 1);

        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'introduction' => $product->introduction,
            'first_img' => $first_img,
            'images' => $images,
            'colors' => $colors,
            'sizes' => $sizes,
            'types' => $types,
        ];
    }
}
