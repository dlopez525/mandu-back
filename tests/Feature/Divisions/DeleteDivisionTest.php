<?php

namespace Tests\Feature\Divisions;

use App\Models\Division;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteDivisionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @test
     */
    function can_delete_division()
    {
        $this->withoutExceptionHandling();

        $division = Division::factory()->create(['name' => 'CEO']);

        $response = $this->withoutExceptionHandling()->postJson(route('divisions.delete', $division->id));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('divisions', $division->toArray());
    }
}
