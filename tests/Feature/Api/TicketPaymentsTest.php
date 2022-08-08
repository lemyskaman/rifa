<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Payment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketPaymentsTest extends TestCase
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
    public function it_gets_ticket_payments()
    {
        $ticket = Ticket::factory()->create();
        $payments = Payment::factory()
            ->count(2)
            ->create([
                'ticket_id' => $ticket->id,
            ]);

        $response = $this->getJson(
            route('api.tickets.payments.index', $ticket)
        );

        $response->assertOk()->assertSee($payments[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_ticket_payments()
    {
        $ticket = Ticket::factory()->create();
        $data = Payment::factory()
            ->make([
                'ticket_id' => $ticket->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.tickets.payments.store', $ticket),
            $data
        );

        $this->assertDatabaseHas('payments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $payment = Payment::latest('id')->first();

        $this->assertEquals($ticket->id, $payment->ticket_id);
    }
}
