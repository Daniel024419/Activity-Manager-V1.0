<?php

namespace Database\Seeders;

use App\Models\Update;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Update::factory(30)->create();
        //
    }
}
