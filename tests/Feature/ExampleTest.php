<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_chat_page_renders_the_enhanced_chat_interface(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('data-chat-storage-key="faqbs-chat-messages"', false)
            ->assertSee('id="chatInput"', false);
    }

    public function test_voice_donor_can_access_only_home_and_donateurs_voix(): void
    {
        $user = \App\Models\User::factory()->create([
            'is_voice_donor' => true,
        ]);

        $this->actingAs($user)
            ->get('/')
            ->assertStatus(200);

        $this->actingAs($user)
            ->get('/Donneurs-Voix')
            ->assertStatus(200);

        $this->actingAs($user)
            ->get('/Trésorerie')
            ->assertRedirect('/');

        $this->actingAs($user)
            ->get('/profile')
            ->assertRedirect('/');
    }
}
