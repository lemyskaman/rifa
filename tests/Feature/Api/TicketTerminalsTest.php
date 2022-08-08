<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Terminal;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTerminalsTest extends TestCase
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
    public function it_gets_ticket_terminals()
    {
        $ticket = Ticket::factory()->create();
        $terminals = Terminal::factory()
            ->count(2)
            ->create([
                'ticket_id' => $ticket->id,
            ]);

        $response = $this->getJson(
            route('api.tickets.terminals.index', $ticket)
        );

        $response->assertOk()->assertSee($terminals[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_ticket_terminals()
    {
        $ticket = Ticket::factory()->create();
        $data = Terminal::factory()
            ->make([
                'ticket_id' => $ticket->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tickets.terminals.store', $ticket),
            $data
        );

        $this->assertDatabaseHas('terminals', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $terminal = Terminal::latest('id')->first();

        $this->assertEquals($ticket->id, $terminal->ticket_id);
    }
}
