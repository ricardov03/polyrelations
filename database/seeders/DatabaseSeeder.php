<?php

namespace Database\Seeders;

use App\Models\Publication;
use App\Models\Resource;
use App\Models\Source;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Publication::factory(50)->create();
        Resource::factory(50)->create();
        Source::factory(50)->create();
    }
}
