<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\SubDivision;
use App\Models\SuperiorDivision;
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

         SuperiorDivision::factory(50)->create()->each(function($f) {
             $division = Division::factory()->create();
             $f->division()->save($division);

             $division->subDivisions()->saveMany(
                 \App\Models\SubDivision::factory($this->faker->numberBetween(0, 5))->create()
             );
         });
        Division::factory(155)->create()->each(function ($fq) {
            $fq->subDivisions()->saveMany(
                SubDivision::factory($this->faker->numberBetween(0, 5))->create()
            );
        });
    }
}
