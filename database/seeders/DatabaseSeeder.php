<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        DB::table('hotels')->truncate();
        Hotel::factory(10)->create();
    }
}
