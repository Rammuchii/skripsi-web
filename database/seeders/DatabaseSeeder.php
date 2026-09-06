<?php

namespace Database\Seeders;

use App\Models\FruitPrice;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'email' => 'admin@fruitvision.test',
                'password' => 'admin123',
                'is_admin' => true,
            ]
        );

        foreach (FruitPrice::EDITABLE_FRUITS as $fruit) {
            FruitPrice::firstOrCreate(
                ['fruit' => $fruit],
                ['price' => match ($fruit) {
                    'apple' => 18000,
                    'banana' => 15000,
                    'mango' => 25000,
                    'orange' => 20000,
                    'pineapple' => 12000,
                    'strawberry' => 35000,
                    default => 0,
                }]
            );
        }
    }
}
