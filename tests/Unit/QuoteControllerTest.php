<?php

namespace Tests\Unit;

use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class QuoteControllerTest extends TestCase
{
    public function test_index_returns_view_with_quote(): void
    {
        Http::fake([
            'https://api.kanye.rest' => Http::response(['quote' => 'Test Kanye quote.'], 200),
        ]);

        $controller = new QuoteController();
        $response = $controller->index();

        $this->assertEquals('quote.index', $response->name());
        $this->assertEquals('Test Kanye quote.', $response->getData()['quote']);
    }

    public function test_get_random_quote_returns_json_response(): void
    {
        Http::fake([
            'https://api.kanye.rest' => Http::response(['quote' => 'Another Kanye quote.'], 200),
        ]);

        $controller = new QuoteController();
        $response = $controller->getRandomQuote();

        $this->assertEquals(
            ['quote' => 'Another Kanye quote.'],
            $response->getData(true)
        );
    }


    public function test_fetch_random_quote_handles_failed_response(): void
    {
        Http::fake([
            'https://api.kanye.rest' => Http::response([], 500),
        ]);

        $controller = new QuoteController();
        $response = $controller->index();

        $this->assertStringContainsString('Failed to fetch quote.', $response->getData()['quote']);
    }

    public function test_fetch_random_quote_handles_exception(): void
    {
        Http::fake([
            'https://api.kanye.rest' => function () {
                throw new \Exception('Something went wrong!');
            },
        ]);

        $controller = new QuoteController();
        $response = $controller->index();

        $this->assertStringContainsString('An error occurred: Something went wrong!', $response->getData()['quote']);
    }
}
