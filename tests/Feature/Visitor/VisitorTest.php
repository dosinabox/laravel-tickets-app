<?php

namespace Tests\Feature\Visitor;

use App\Exports\VisitorsExport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class VisitorTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_new_visitor(): void
    {
        //add
        $response = $this->post('/api/v1/visitors', [
            'name' => 'Bruce',
            'lastName' => 'Wayne',
            'company' => 'WayneCorp',
            'position' => 'vigilante',
            'phone' => '1234567890',
            'telegram' => 'batman',
            'email' => 'admin@waynecorp.com',
        ]);
        $response->assertStatus(201);

        //check if added
        $response = $this->get('/api/v1/visitors');
        $response->assertStatus(200);
        $response->assertJsonFragment(
            [
                'name' => 'Bruce',
                'lastName' => 'Wayne',
                'company' => 'WayneCorp',
                'position' => 'vigilante',
                'phone' => '1234567890',
                'telegram' => '@batman',
                'email' => 'admin@waynecorp.com',
            ]
        );

        //check if visitors can be exported
        Excel::fake();

        $user = User::factory()->create();
        $this->actingAs($user)->get('/export');

        Excel::assertDownloaded('visitors.xlsx', static function(VisitorsExport $export) {
            return $export->collection()->contains('email', 'admin@waynecorp.com');
        });

        //check missing
        $response = $this->get('/api/v1/visitor/9999999999999');
        $response->assertStatus(404);

        //update
        $response = $this->post('/api/v1/visitors/1', [
            'category' => 'VIP',
            'isRejected' => true,
        ]);
        $response->assertStatus(200);

        //check if updated
        $response = $this->get('/api/v1/visitors');
        $response->assertStatus(200);
        $response->assertJsonFragment(
            [
                'category' => 'VIP',
                'isRejected' => true,
            ]
        );

        //search positive
        $response = $this->get('/api/v1/search/bruce');
        $response->assertStatus(200);
        $response->assertJsonFragment(
            [
                'name' => 'Bruce',
                'lastName' => 'Wayne',
            ]
        );

        //search negative
        $response = $this->get('/api/v1/search/joker');
        $response->assertStatus(200);
        $response->assertExactJson([]);

        //delete
        $response = $this->delete('/api/v1/visitors/1');
        $response->assertStatus(200);

        //check if deleted
        $response = $this->get('/api/v1/visitors');
        $response->assertStatus(200);
        $response->assertExactJson([]);
    }
}
