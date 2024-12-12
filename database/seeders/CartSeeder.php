<?php

namespace Database\Seeders;

use App\Enums\CartStatus;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1);

        $user->cart()->create([
            'status' => CartStatus::ACTIVE->name
        ]);
    }
}
