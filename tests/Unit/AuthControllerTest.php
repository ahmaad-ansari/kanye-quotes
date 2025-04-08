<?php

namespace Tests\Unit;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Session::start(); // Start session for tests
    }

    public function test_show_login_form_redirects_if_authenticated(): void
    {
        Session::put('is_authenticated', true);

        $controller = new AuthController();
        $response = $controller->showLoginForm();

        $this->assertEquals(route('quote.index'), $response->getTargetUrl());
    }

    public function test_show_login_form_displays_login_view_if_not_authenticated(): void
    {
        Session::forget('is_authenticated');

        $controller = new AuthController();
        $response = $controller->showLoginForm();

        $this->assertEquals('auth.login', $response->name());
    }

    public function test_successful_login_redirects_to_quote_index(): void
    {
        config(['auth.app_password' => 'correct-password']);

        $request = Request::create('/login', 'POST', [
            'password' => 'correct-password',
        ]);

        $controller = new AuthController();
        $response = $controller->login($request);

        $this->assertTrue(Session::get('is_authenticated'));
        $this->assertEquals(route('quote.index'), $response->getTargetUrl());
    }

    public function test_failed_login_redirects_back_with_errors(): void
    {
        config(['auth.app_password' => 'correct-password']);

        $request = Request::create('/login', 'POST', [
            'password' => 'wrong-password',
        ]);

        $controller = new AuthController();
        $response = $controller->login($request);

        $this->assertFalse(Session::has('is_authenticated'));
        $this->assertEquals(url('/login'), $response->getTargetUrl());
        $this->assertNotEmpty(session('errors'));
    }

    public function test_logout_clears_authentication_and_redirects(): void
    {
        Session::put('is_authenticated', true);

        $controller = new AuthController();
        $response = $controller->logout();

        $this->assertFalse(Session::has('is_authenticated'));
        $this->assertEquals(route('login'), $response->getTargetUrl());
    }
}
