<?php

namespace Divisions;

use App\Models\Ambassador;
use App\Models\Division;
use App\Models\SubDivision;
use App\Models\SuperiorDivision;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\AssignOp\Div;
use Tests\TestCase;
use function route;

class CreateDivisionTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @test
     */
    function can_create_division()
    {
        $this->withoutExceptionHandling();

        $ambassador = Ambassador::factory()->create();
        $superiorDivision = SuperiorDivision::factory()->create();

        $data = ['name' => 'CEO', 'level' => 1, 'number_collaborators' => 54, 'ambassador_id' => $ambassador->id, 'superior_division_id' => $superiorDivision->id];

        $response = $this->json('post', route('divisions.store'), $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('divisions', $data);
    }

    /**
     *
     * @test
     */
    function can_create_division_without_super_division()
    {
        $this->withoutExceptionHandling();

        $ambassador = Ambassador::factory()->create();

        $data = ['name' => 'CEO', 'level' => 1, 'number_collaborators' => 54, 'ambassador_id' => $ambassador->id, 'superior_division_id' => null];

        $response = $this->json('post', route('divisions.store'), $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('divisions', $data);
    }

    /**
     *
     * @test
     */
    function can_create_division_with_super_division()
    {
        $this->withoutExceptionHandling();

        $ambassador = Ambassador::factory()->create();
        $superDivision = SuperiorDivision::factory()->create();

        $data = ['name' => 'ADMINISTRATION', 'level' => 1, 'number_collaborators' => 54, 'ambassador_id' => $ambassador->id, 'superior_division_id' => $superDivision->id];

        $response = $this->json('post', route('divisions.store'), $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('divisions', $data);
    }

    /**
     *
     * @test
     */
    function a_division_has_many_subdivisions()
    {
        $this->withoutExceptionHandling();

        $ambassador = Ambassador::factory()->create();
        $superDivision = SuperiorDivision::factory()->create();
        $division = Division::factory()->create(['ambassador_id' => $ambassador->id, 'superior_division_id' => $superDivision->id]);
        $subDivision = SubDivision::factory()->create(['division_id' => $division->id]);

        $this->assertTrue($division->subDivisions->contains($subDivision));
        $this->assertEquals(1, $division->subDivisions->count());
    }

    /**
     *
     * @test
     */
    function a_division_is_unique()
    {
        $this->withoutExceptionHandling();

        $ambassador = Ambassador::factory()->create();
        $division = Division::factory()->create(['name' => 'CEO']);

        $data = ['name' => 'CEO', 'level' => 1, 'number_collaborators' => 54, 'ambassador_id' => $ambassador->id];

        $response = $this->withHeader('Accept', 'application/json')->json('post','/api/divisions/store', $data);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('name');
    }

    /**
     * A basic feature test example.
     *
     * @test
     */
    function a_division_require_a_name()
    {
        $this->withoutExceptionHandling();

        $ambassador = Ambassador::factory()->create();
        $superiorDivision = SuperiorDivision::factory()->create();

        $data = ['name' => '', 'level' => 1, 'number_collaborators' => 54, 'ambassador_id' => $ambassador->id, 'superior_division_id' => $superiorDivision->id];

        $response = $this->withoutExceptionHandling()->postJson(route('divisions.store'), $data);

        $response->assertStatus(422);

        $response->assertJsonStructure(['errors' => ['name']]);
    }

    /**
     * A basic feature test example.
     *
     * @test
     */
    function a_division_name_maxlength()
    {
        $this->withoutExceptionHandling();

        $ambassador = Ambassador::factory()->create();
        $superiorDivision = SuperiorDivision::factory()->create();

        $data = ['name' => Str::random(50), 'level' => 1, 'number_collaborators' => 54, 'ambassador_id' => $ambassador->id, 'superior_division_id' => $superiorDivision->id];

        $response = $this->withoutExceptionHandling()->postJson(route('divisions.store'), $data);

        $response->assertStatus(422);

        $response->assertJsonStructure(['errors' => ['name']]);
    }

    /**
     * A basic feature test example.
     *
     * @test
     */
    function a_division_require_a_level()
    {
        $this->withoutExceptionHandling();

        $ambassador = Ambassador::factory()->create();
        $superiorDivision = SuperiorDivision::factory()->create();

        $data = ['name' => 'CEO', 'level' => null, 'number_collaborators' => 54, 'ambassador_id' => $ambassador->id, 'superior_division_id' => $superiorDivision->id];

        $response = $this->withoutExceptionHandling()->postJson(route('divisions.store'), $data);

        $response->assertStatus(422);

        $response->assertJsonStructure(['errors' => ['level']]);
    }

    /**
     * A basic feature test example.
     *
     * @test
     */
    function a_division_require_a_number_collaborators()
    {
        $this->withoutExceptionHandling();

        $ambassador = Ambassador::factory()->create();
        $superiorDivision = SuperiorDivision::factory()->create();

        $data = ['name' => 'CEO', 'level' => 12, 'number_collaborators' => null, 'ambassador_id' => $ambassador->id, 'superior_division_id' => $superiorDivision->id];

        $response = $this->withoutExceptionHandling()->postJson(route('divisions.store'), $data);

        $response->assertStatus(422);

        $response->assertJsonStructure(['errors' => ['number_collaborators']]);
    }

    /**
     * A basic feature test example.
     *
     * @test
     */
    function a_division_require_a_ambassador()
    {
        $this->withoutExceptionHandling();

        $ambassador = Ambassador::factory()->create();
        $superiorDivision = SuperiorDivision::factory()->create();

        $data = ['name' => 'CEO', 'level' => 12, 'number_collaborators' => 43, 'ambassador_id' => null, 'superior_division_id' => $superiorDivision->id];

        $response = $this->withoutExceptionHandling()->postJson(route('divisions.store'), $data);

        $response->assertStatus(422);

        $response->assertJsonStructure(['errors' => ['ambassador_id']]);
    }
}
