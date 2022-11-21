<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TicketTest extends TestCase
{
    /** @test */
    public function can_get_ticket_list()
    {
        $response = $this->getJson(route('api.ticket.index'));
        $result = collect($response->json()['data']);

        $this->assertTrue($result->count() > 0);

        $response->assertStatus(200);
    }

    /** @test */
    public function can_get_ticket_list_by_search()
    {
        $response = $this->getJson(route('api.ticket.index', [
            'search' => 'Ticket 1'
        ]));

        $result = collect($response->json()['data']);

        $this->assertTrue($result->count() > 0);

        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_ticket()
    {
        $this->postJson(route('api.ticket.store'), [
            'title' => 'Ticket 6',
            'company' => 'Company 3',
            'project' => 'Project 3',
            'domain' => 'project.tiga.com',
            'description' => 'bug',
            'created_by' => 'PIC Project Tiga',
        ])->assertCreated();

        $ticket = Ticket::where('title', 'Ticket 6')->first();
        $this->assertNotNull($ticket);
    }

    /** @test */
    public function can_get_ticket_by_code()
    {
        $ticket = Ticket::where('title', 'Ticket 6')->first();

        $response = $this->getJson(route('api.ticket.show.by.code', $ticket->code));

        $this->assertTrue(collect($response->json()['data'])->count() > 0);

        $response->assertOk();
    }

    /** @test */
    public function can_get_ticket_by_id_with_login()
    {
        Sanctum::actingAs(User::find(1));
        $ticket = Ticket::where('title', 'Ticket 6')->first();

        $response = $this->getJson(route('api.ticket.show', $ticket->id));

        $this->assertTrue(collect($response->json()['data'])->count() > 0);

        $response->assertOk();
    }

    /** @test */
    public function can_not_get_ticket_by_id_without_login()
    {
        $ticket = Ticket::where('title', 'Ticket 6')->first();

        $response = $this->getJson(route('api.ticket.show', $ticket->id));

        $response->assertUnauthorized();
    }

    /** @test */
    public function can_update_ticket_with_login()
    {
        Sanctum::actingAs(User::find(1));
        $ticket = Ticket::where('title', 'Ticket 6')->first();

        $this->putJson(route('api.ticket.update', $ticket->id), [
            'title' => 'Ticket 6 Edited',
            'company' => 'Company 3',
            'project' => 'Project 3',
            'domain' => 'project.tiga.com',
            'description' => 'bug',
            'created_by' => 'PIC Project Tiga',
        ])->assertOk();

        $ticket = Ticket::where('title', 'Ticket 6')->first();
        $this->assertNull($ticket);

        $ticket = Ticket::where('title', 'Ticket 6 Edited')->first();
        $this->assertNotNull($ticket);
    }

    /** @test */
    public function can_update_ticket_without_login()
    {
        $ticket = Ticket::where('title', 'Ticket 6 Edited')->first();

        $this->putJson(route('api.ticket.update', $ticket->id), [
            'title' => 'Ticket 6 Edited',
            'company' => 'Company 3',
            'project' => 'Project 3',
            'domain' => 'project.tiga.com',
            'description' => 'bug',
            'created_by' => 'PIC Project Tiga',
        ])->assertUnauthorized();
    }

    /** @test */
    public function can_delete_ticket_without_login()
    {
        $ticket = Ticket::where('title', 'Ticket 6 Edited')->first();

        $this->deleteJson(route('api.ticket.destroy', $ticket->id))->assertUnauthorized();
    }

    /** @test */
    public function can_delete_ticket_with_login()
    {
        Sanctum::actingAs(User::find(1));
        $ticket = Ticket::where('title', 'Ticket 6 Edited')->first();

        $this->deleteJson(route('api.ticket.update', $ticket->id))->assertOk();
    }
}
