<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuoteController extends Controller
{
    // Show the quote page with a random quote
    public function index()
    {
        $quote = $this->fetchRandomQuote();  // Fetch random quote
        return view('quote.index', compact('quote'));  // Return view with quote
    }

    // Return a random quote as a JSON response
    public function getRandomQuote()
    {
        $quote = $this->fetchRandomQuote();  // Fetch random quote
        return response()->json(['quote' => $quote]);  // Return quote as JSON
    }

    // Fetch a random quote from the Kanye API
    private function fetchRandomQuote()
    {
        try {
            $response = Http::get('https://api.kanye.rest');  // Make API request

            if ($response->successful()) {
                return $response->json()['quote'];  // Return quote if successful
            }

            return 'Failed to fetch quote.';  // Error message if request fails
        } catch (\Exception $e) {
            return 'An error occurred: ' . $e->getMessage();  // Error handling
        }
    }
}
