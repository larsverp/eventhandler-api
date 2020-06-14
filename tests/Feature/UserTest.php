<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegistration()
    {
        $response = $this->postJson('api/users/register', [
            'first_name' => 'Lars',
            'insertion' => null,
            'last_name' => 'Jansen',
            'email' => 'lars@test.nl',
            'postal_code' => '1234AB',
            'password' => 'password',
            ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'role' => 'guest',
            ]);
    }

    
}
