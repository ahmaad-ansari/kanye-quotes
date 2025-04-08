<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuoteController extends Controller
{
    public function index()
    {
        $quote = $this->fetchRandomQuote();
        return view('quote.index', compact('quote'));
    }

    public function getRandomQuote()
    {
        $quote = $this->fetchRandomQuote();
        return response()->json(['quote' => $quote]);
    }

    private function fetchRandomQuote()
    {
        try {
            $response = Http::get('https://api.kanye.rest');

            if ($response->successful()) {
                return $response->json()['quote'];
            }

            return 'Failed to fetch quote.';
        } catch (\Exception $e) {
            return 'An error occurred: ' . $e->getMessage();
        }
    }
}
