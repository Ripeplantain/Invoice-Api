<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CreateTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    private $privateUrl = '/api/v1/customer';

    /**
     * Test the store method.
     *
     * @return void
     */
    public function testStore()
    {

        $customerData = [
            'name' => 'Test Customer',
            'email' => 'test@customer.com'
        ];

        $response = $this->postJson($this->privateUrl, $customerData);

        $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Customer created successfully',
            'data' => $customerData
        ]);

        $this->assertDatabaseHas('customers', $customerData);
    }
}
