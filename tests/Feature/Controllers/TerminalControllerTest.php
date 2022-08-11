<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Terminal;

use App\Models\Ticket;
use App\Models\Raffle;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TerminalControllerTest extends TestCase
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
    public function it_displays_index_view_with_terminals()
    {
        $terminals = Terminal::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('terminals.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.terminals.index')
            ->assertViewHas('terminals');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_terminal()
    {
        $response = $this->get(route('terminals.create'));

        $response->assertOk()->assertViewIs('app.terminals.create');
    }

    /**
     * @test
     */
    public function it_stores_the_terminal()
    {
        $data = Terminal::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('terminals.store'), $data);

        $this->assertDatabaseHas('terminals', $data);

        $terminal = Terminal::latest('id')->first();

        $response->assertRedirect(route('terminals.edit', $terminal));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_terminal()
    {
        $terminal = Terminal::factory()->create();

        $response = $this->get(route('terminals.show', $terminal));

        $response
            ->assertOk()
            ->assertViewIs('app.terminals.show')
            ->assertViewHas('terminal');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_terminal()
    {
        $terminal = Terminal::factory()->create();

        $response = $this->get(route('terminals.edit', $terminal));

        $response
            ->assertOk()
            ->assertViewIs('app.terminals.edit')
            ->assertViewHas('terminal');
    }

    /**
     * @test
     */
    public function it_updates_the_terminal()
    {
        $terminal = Terminal::factory()->create();

        $ticket = Ticket::factory()->create();
        $raffle = Raffle::factory()->create();

        $data = [
            'number' => $this->faker->randomNumber,
            'status' => 'available',
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'ticket_id' => $ticket->id,
            'raffle_id' => $raffle->id,
        ];

        $response = $this->put(route('terminals.update', $terminal), $data);

        $data['id'] = $terminal->id;

        $this->assertDatabaseHas('terminals', $data);

        $response->assertRedirect(route('terminals.edit', $terminal));
    }

    /**
     * @test
     */
    public function it_deletes_the_terminal()
    {
        $terminal = Terminal::factory()->create();

        $response = $this->delete(route('terminals.destroy', $terminal));

        $response->assertRedirect(route('terminals.index'));

        $this->assertSoftDeleted($terminal);
    }
}
