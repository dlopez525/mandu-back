<?php

namespace Tests\Feature\Divisions;

use App\Http\Resources\DivisionCollection;
use App\Http\Resources\DivisionResource;
use App\Models\Ambassador;
use App\Models\Division;
use App\Models\SuperiorDivision;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetDivisionTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @test
     */
    function exist_division_resource()
    {
        $this->withoutExceptionHandling();

        $division = Division::factory()->create();

        $response = DivisionResource::make($division)->resolve();

        $this->assertArrayHasKey('name', $response);
        $this->assertEquals($division->name, $response['name']);
        $this->assertEquals($division->level, $response['level']);
        $this->assertEquals($division->number_collaborators, $response['number_collaborators']);
        $this->assertEquals($division->ambassador_id, $response['ambassador_id']);
    }

    /**
     *
     * @test
     */
    function can_get_division_by_id()
    {
        $this->withoutExceptionHandling();

        $division = Division::factory()->create();
        $resource = DivisionResource::make($division);
        $resourceCollection = $resource->response()->getData(true);

        $response = $this->json('get', route('division.get', $division->id));

        $response->assertStatus(200);
        $this->assertEquals($response->json(), $resourceCollection);
    }

    /**
     *
     * @test
     */
    function can_get_all_divisions()
    {
        $this->withoutExceptionHandling();

        $divisions = Division::factory(50)->create();

        $collection = DivisionCollection::make($divisions);
        $collectionResponse = $collection->response()->getData(true);

        $response = $this->json('get', route('divisions.get'));
        $response->assertStatus(200);

        $this->assertEquals($response->json(), $collectionResponse);
    }
}
