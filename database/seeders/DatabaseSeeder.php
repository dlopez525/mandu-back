<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private \Faker\Generator $faker;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Factory::create();

         \App\Models\Ambassador::factory(10)->create();
         \App\Models\SuperiorDivision::factory(20)->create()->each(function($f) {
             $f->division()->save(
                 \App\Models\Division::factory()->create()
             );
         });
         \App\Models\Division::factory(55)->create()->each(function ($f) {
             $f->subDivisions()->saveMany(
                 \App\Models\SubDivision::factory($this->faker->numberBetween(0, 3))->create()
             );
         });
        \App\Models\Division::factory(60)->create();
    }
}
