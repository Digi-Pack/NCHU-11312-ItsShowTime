<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typeNames = ['神風', '特攻', '極惡', '暴走', '台灣聯合', '客製化'];

        foreach ($typeNames as $index => $name) {
            Type::create([
                'type_name' => $name,
                'sort_order' => $index + 1,
            ]);
        };
    }
}
