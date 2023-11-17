<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class RefreshTokenTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    private $privateUrl = '/api/v1/refresh/token';

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    /**
     * Test the refresh method.
     *
     * @return void
     */
    public function testRefresh()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        $response = $this->postJson($this->privateUrl);

        $response->assertStatus(200);
        $this->assertNotEmpty($response['token']);
    }
}

