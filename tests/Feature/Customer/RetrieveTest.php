<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RetrieveTest extends TestCase
{

    use RefreshDatabase, WithoutMiddleware;

    /**
     * Test the show method.
     *
     * @return void
     */
    public function testShow()
    {
        $customer = Customer::factory()->create();
        $url = '/api/v1/customer/' . $customer->id;

        $response = $this->get($url);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
            ]
        ]);
    }
}
