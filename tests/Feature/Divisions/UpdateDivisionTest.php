<?php

namespace Tests\Feature\Divisions;

use App\Models\Division;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateDivisionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @test
     */
    function a_division_require_a_level()
    {
        $this->withoutExceptionHandling();

        $division = Division::factory()->create(['name' => 'CEO']);

        $newData = ['name' => 'CEO32', 'level' => $division->level, 'number_collaborators' => $division->number_collaborators, 'ambassador_id' => $division->ambassador_id, 'superior_division_id' => $division->superior_division_id];

        $response = $this->withoutExceptionHandling()->postJson(route('divisions.update', $division->id), $newData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('divisions', $newData);
        $this->assertEquals($response['data']['name'], $newData['name']);
        $this->assertEquals($response['data']['level'], $newData['level']);
        $this->assertEquals($response['data']['number_collaborators'], $newData['number_collaborators']);
        $this->assertEquals($response['data']['ambassador_id'], $newData['ambassador_id']);
    }
}
