<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Item;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
        ]);
        Invoice::factory(1)->create();
        Item::factory(1)->create();
        InvoiceItem::factory(1)->create();
    }
}
