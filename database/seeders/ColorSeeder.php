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

        foreach ($colorNames as $name) {
            Color::create([
                'color_name' => $name,
            ]);
        };
    }
}
