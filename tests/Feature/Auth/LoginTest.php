<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    private $privateUrl = '/api/v1/login';

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }

    /**
     * Test a successful login.
     *
     * @return void
     */
    public function testSuccessfulLogin()
    {
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'unit@test.com',
            'password' => bcrypt('password')
        ]);

        $data = [
            'email' => 'unit@test.com',
            'password' => 'password'
        ];

        $response = $this->postJson($this->privateUrl, $data);

        $response->assertStatus(200)
            ->assertJson([
                'token' => true
            ]);
    }

    /**
     * Test a failed login due to invalid email.
     *
     * @return void
     */
    public function testFailedLoginInvalidEmail()
    {
        $response = $this->postJson($this->privateUrl, [
            'email' => 'invalid@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'User not found',
            ]);
    }

    /**
     * Test a failed login due to invalid password.
     *
     * @return void
     */
    public function testFailedLoginInvalidPassword()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson($this->privateUrl, [
            'email' => $user->email,
            'password' => 'invalid',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid Password',
            ]);
    }
}

