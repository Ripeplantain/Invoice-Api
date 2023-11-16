<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class LogoutTest extends TestCase
{

    use RefreshDatabase, WithoutMiddleware;

    private $privateUrl = '/api/v1/logout';

    /**
     * Test the logout method.
     *
     * @return void
     */
    public function testLogout()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        $response = $this->postJson($this->privateUrl);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'User logged out successfully',
        ]);

        $this->assertEmpty($user->tokens);
    }
}
