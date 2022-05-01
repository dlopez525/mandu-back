<?php

namespace Tests\Feature\Divisions;

use App\Http\Resources\DivisionResource;
use App\Http\Resources\SubDivisionResource;
use App\Models\Division;
use App\Models\SubDivision;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubDivicionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @test
     */
    public function a_division_can_has_many_subdivisions()
    {
        $this->withoutExceptionHandling();

        $division = Division::factory()->create();

        $subdivision = SubDivision::factory(5)->create(['division_id' => $division->id]);

        $response = DivisionResource::make($division);
        $collectionResponse = $response->response()->getData(true);

        $this->assertArrayHasKey('sub_divisions', $collectionResponse['data']);

        foreach ($collectionResponse['data']['sub_divisions'] as $key => $res) {
            $this->assertEquals($subdivision[$key]->id, $res['id']);
            $this->assertEquals($subdivision[$key]->name, $res['name']);
        }
    }
}
