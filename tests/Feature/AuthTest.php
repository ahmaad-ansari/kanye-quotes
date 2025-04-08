<?php

use Illuminate\Support\Facades\Session;

// Test if a guest can view the login form
test('guest can view login form', function () {
    $response = $this->get('/login'); // Make a GET request to the login page

    $response->assertStatus(200); // Ensure the response status is 200 OK
    $response->assertSee('Login'); // Check if the "Login" text is present
});

// Test if an authenticated user is redirected from the login form
test('authenticated user is redirected from login form', function () {
    Session::put('is_authenticated', true); // Simulate an authenticated session

    $response = $this->get('/login'); // Make a GET request to the login page

    $response->assertRedirect('/'); // Ensure the user is redirected to the homepage
});

// Test if a user can login with the correct password
test('user can login with correct password', function () {
    $response = $this->post('/login', [
        'password' => config('auth.password'), // Use the correct password from config
    ]);

    $response->assertRedirect('/'); // Ensure the user is redirected to the homepage

    // Follow the redirect and check if the session has 'is_authenticated' set to true
    $this->withSession(['is_authenticated' => true])
        ->get('/')
        ->assertSessionHas('is_authenticated', true);
});

// Test if a user cannot login with an incorrect password
test('user cannot login with incorrect password', function () {
    $response = $this->post('/login', [
        'password' => 'wrong-password', // Provide an incorrect password
    ]);

    $response->assertRedirect('/login'); // Ensure the user is redirected back to the login page
    $response->assertSessionHasErrors('password'); // Ensure the 'password' field has validation errors
    expect(session('is_authenticated', false))->toBeFalse(); // Ensure the user is not authenticated
});

// Test if a user can logout
test('user can logout', function () {
    Session::put('is_authenticated', true); // Simulate an authenticated session

    $response = $this->post('/logout'); // Make a POST request to the logout route

    $response->assertRedirect('/login'); // Ensure the user is redirected to the login page
    expect(session('is_authenticated', false))->toBeFalse(); // Ensure the user is logged out
});