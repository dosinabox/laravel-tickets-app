<?php

namespace Tests\Feature\Visitor;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitorTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_new_visitor(): void
    {
        //add
        $response = $this->post('/visitors', [
            'name' => 'Bruce',
            'lastName' => 'Wayne',
            'status' => 'vigilante',
            'company' => 'WayneCorp',
            'phone' => '1234567890',
            'telegram' => 'batman',
            'email' => 'admin@waynecorp.com',
        ]);
        $response->assertStatus(201);

        //login
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        //check if added
        $response = $this->get('/visitors');
        $response->assertStatus(200);
        $response->assertJsonFragment(
            [
                'name' => 'Bruce',
                'lastName' => 'Wayne',
                'status' => 'vigilante',
                'company' => 'WayneCorp',
                'phone' => '1234567890',
                'telegram' => 'batman',
                'email' => 'admin@waynecorp.com',
            ]
        );

        //update
        $response = $this->post('/visitors/1', [
            'name' => 'Thomas',
            'lastName' => 'Elliot',
        ]);
        $response->assertStatus(200);

        //check if updated
        $response = $this->get('/visitors');
        $response->assertStatus(200);
        $response->assertJsonFragment(
            [
                'name' => 'Thomas',
                'lastName' => 'Elliot',
            ]
        );

        //delete
        $response = $this->delete('/visitors/1');
        $response->assertStatus(200);

        //check if updated
        $response = $this->get('/visitors');
        $response->assertStatus(200);
        $response->assertExactJson([]);
    }
}
