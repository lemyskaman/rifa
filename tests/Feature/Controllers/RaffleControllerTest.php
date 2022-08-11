<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Raffle;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RaffleControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_raffles()
    {
        $raffles = Raffle::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('raffles.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.raffles.index')
            ->assertViewHas('raffles');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_raffle()
    {
        $response = $this->get(route('raffles.create'));

        $response->assertOk()->assertViewIs('app.raffles.create');
    }

    /**
     * @test
     */
    public function it_stores_the_raffle()
    {
        $data = Raffle::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('raffles.store'), $data);

        $this->assertDatabaseHas('raffles', $data);

        $raffle = Raffle::latest('id')->first();

        $response->assertRedirect(route('raffles.edit', $raffle));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_raffle()
    {
        $raffle = Raffle::factory()->create();

        $response = $this->get(route('raffles.show', $raffle));

        $response
            ->assertOk()
            ->assertViewIs('app.raffles.show')
            ->assertViewHas('raffle');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_raffle()
    {
        $raffle = Raffle::factory()->create();

        $response = $this->get(route('raffles.edit', $raffle));

        $response
            ->assertOk()
            ->assertViewIs('app.raffles.edit')
            ->assertViewHas('raffle');
    }

    /**
     * @test
     */
    public function it_updates_the_raffle()
    {
        $raffle = Raffle::factory()->create();

        $data = [
            'name' => $this->faker->unique->name,
            'date' => $this->faker->date,
        ];

        $response = $this->put(route('raffles.update', $raffle), $data);

        $data['id'] = $raffle->id;

        $this->assertDatabaseHas('raffles', $data);

        $response->assertRedirect(route('raffles.edit', $raffle));
    }

    /**
     * @test
     */
    public function it_deletes_the_raffle()
    {
        $raffle = Raffle::factory()->create();

        $response = $this->delete(route('raffles.destroy', $raffle));

        $response->assertRedirect(route('raffles.index'));

        $this->assertModelMissing($raffle);
    }
}
