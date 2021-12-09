<?php

namespace Database\Seeders;

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
        $tags = [
            ['name' => 'Food'],
            ['name' => 'Clothes'],
            ['name' => 'Kids'],
            ['name' => 'Materials'],
            ['name' => 'Hygiene'],
            ['name' => 'Miscellany']
        ];

        DB::table('tags')->insert($tags);
    }
}
