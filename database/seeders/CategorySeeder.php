<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Food',
            'Travel',
            'Shopping',
            'Bills',
            'Health',
            'Education',
            'Entertainment',
            'Rent',
            'Savings',
            'Income',
            'Other'
        ];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate(
                ['name' => $categoryName]
            );
        }
    }
}

