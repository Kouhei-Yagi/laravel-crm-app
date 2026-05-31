<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Interaction;
use App\Models\Project;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);
        Customer::factory(60)->create();
        Project::factory(100)->create();
        Interaction::factory(250)->create();
    }
}
