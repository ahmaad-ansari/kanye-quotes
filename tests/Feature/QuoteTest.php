<?php

use function Pest\Laravel\{get, getJson, withSession};

// Test if authenticated user can access the quote page
test('authenticated user can access quote page', function () {
    withSession(['is_authenticated' => true]) // Simulate logged-in user
        ->get('/') // Access the quote page
        ->assertStatus(200) // Check that the page loads successfully
        ->assertSee('Random Kanye West Quote'); // Ensure the page contains the expected text
});

// Test if unauthenticated user is redirected to login
test('unauthenticated user is redirected to login', function () {
    get('/') // Access the quote page
        ->assertRedirect('/login'); // Ensure unauthenticated users are redirected to login
});

// Test if the API returns a random quote when the user is authenticated
test('api returns random quote when authenticated', function () {
    getJson('/api/quotes', [
        'Authorization' => 'Bearer ' . config('auth.api_token') // Provide valid token
    ])
        ->assertStatus(200) // Ensure the response is OK
        ->assertJsonStructure(['quote']); // Ensure the response contains 'quote' field
});

// Test if the API returns 401 for an invalid token
test('api returns 401 for invalid token', function () {
    getJson('/api/quotes', [
        'Authorization' => 'Bearer invalid-token' // Provide invalid token
    ])
        ->assertStatus(401) // Ensure the response is Unauthorized
        ->assertJson(['error' => 'Unauthorized']); // Assert Unauthorized error message
});

// Test if the refresh button fetches a new quote
test('refresh button fetches a new quote', function () {
    // Ensure the user is authenticated
    $response = withSession(['is_authenticated' => true])
        ->get('/'); // Access the quote page

    $response->assertStatus(200) // Ensure the page loads
        ->assertSee('Get Another Quote'); // Ensure the refresh button is present

    // Simulate clicking the refresh button by calling the API
    $apiResponse = $this->getJson('/api/quotes', [
        'Authorization' => 'Bearer ' . config('auth.api_token') // Add valid token
    ]);

    $apiResponse->assertStatus(200) // Ensure the response is OK
        ->assertJsonStructure(['quote']); // Ensure the response contains 'quote'
});
