<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UpdateTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    private $privateUrl = '/api/v1/customer/';

    /**
     * Test the update method.
     *
     * @return void
     */
    public function testUpdate()
    {

        $customer = Customer::factory()->create();

        $newCustomerData = [
            'name' => 'Updated Customer',
            'email' => 'updated@customer.com'
        ];

        $response = $this->putJson($this->privateUrl . $customer->id, $newCustomerData);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Customer updated successfully',
            'data' => $newCustomerData
        ]);

        $this->assertDatabaseHas('customers', $newCustomerData);
    }
}
