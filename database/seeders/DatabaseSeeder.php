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

         \App\Models\SuperiorDivision::factory(20)->create()->each(function($f) {
             \App\Models\Division::factory(5)->create()->each(function ($fq) use ($f) {
                 $f->division()->save($fq);
                 $fq->subDivisions()->saveMany(
                     \App\Models\SubDivision::factory($this->faker->numberBetween(0, 5))->create()
                 );
             });
         });
        \App\Models\Division::factory(55)->create()->each(function ($fq) {
            $fq->subDivisions()->saveMany(
                \App\Models\SubDivision::factory($this->faker->numberBetween(0, 5))->create()
            );
        });
    }
}
