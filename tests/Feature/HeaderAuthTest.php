<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class HeaderAuthTest extends TestCase
{
    public function test_guest_sees_login_button_in_header()
    {
        $settings = (object) [
            'site_name' => 'Test Site',
            'site_name_en' => 'TEST SITE',
        ];

        $html = view('partials.header', compact('settings'))->render();

        $this->assertStringContainsString('data-open-auth-modal="1"', $html);
        $this->assertStringContainsString('登录', $html);
    }

    public function test_authenticated_user_sees_console_link_in_header()
    {
        $settings = (object) [
            'site_name' => 'Test Site',
            'site_name_en' => 'TEST SITE',
        ];

        $user = new User(['id' => 1, 'name' => 'Tester', 'email' => 'tester@example.com']);
        $this->actingAs($user);

        $html = view('partials.header', compact('settings'))->render();

        $this->assertStringContainsString(route('orders.index'), $html);
        $this->assertStringContainsString('控制台', $html);
    }
}
