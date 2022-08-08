<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Terminal;

use App\Models\Ticket;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TerminalTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_terminals_list()
    {
        $terminals = Terminal::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.terminals.index'));

        $response->assertOk()->assertSee($terminals[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_terminal()
    {
        $data = Terminal::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.terminals.store'), $data);

        $this->assertDatabaseHas('terminals', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_terminal()
    {
        $terminal = Terminal::factory()->create();

        $ticket = Ticket::factory()->create();

        $data = [
            'number' => $this->faker->randomNumber,
            'status' => 'available',
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'ticket_id' => $ticket->id,
        ];

        $response = $this->putJson(
            route('api.terminals.update', $terminal),
            $data
        );

        $data['id'] = $terminal->id;

        $this->assertDatabaseHas('terminals', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_terminal()
    {
        $terminal = Terminal::factory()->create();

        $response = $this->deleteJson(
            route('api.terminals.destroy', $terminal)
        );

        $this->assertSoftDeleted($terminal);

        $response->assertNoContent();
    }
}
