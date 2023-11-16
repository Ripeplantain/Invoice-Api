<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    private $privateUrl = '/api/v1/register';

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }


    public function testSuccessfulRegistration()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password'
        ];

        $response = $this->postJson($this->privateUrl, $data);

        $response->assertStatus(201)
            ->assertJson([
                'token' => true 
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com'
        ]);
    }
}
