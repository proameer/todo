<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TodoType;

class todoTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TodoType::create(['name' => 'اعتيادي']);
        TodoType::create(['name' => 'عاجل']);
        TodoType::create(['name' => 'مؤجل']);
        TodoType::create(['name' => 'ضروري']);
    }
}
