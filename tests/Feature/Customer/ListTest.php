<?php

namespace Tests\Feature\Customer;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ListTest extends TestCase
{

    use RefreshDatabase, WithoutMiddleware;
    
    /**
     * Test the index method.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/api/v1/customer');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }
}
