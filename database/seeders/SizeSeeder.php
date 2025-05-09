<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizeNames = ['S', 'M', 'L', 'XL', '2XL', '3XL', '5XL'];

        foreach ($sizeNames as $name) {
            Size::create([
                'size_name' => $name,
            ]);
        };
    }
}
