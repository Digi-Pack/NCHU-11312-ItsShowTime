<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colorNames = ['黑', '紅'];

        foreach ($colorNames as $index => $name) {
            Color::create([
                'color_name' => $name,
                'sort_order' => $index + 1,

            ]);
        };
    }
}
