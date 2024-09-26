<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get(uri: '/');

        $response->assertStatus(200);
    }
    public function test_me(){
        $response = $this->get(uri: '/login');
        $response->assertStatus(200);
    }
}
