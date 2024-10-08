<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlStoreRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UrlShortenerController extends Controller
{
    public function store(ShortUrlStoreRequest $request)
    {
        $body = [
            'url' => $request->input('url'),
            'domain' => 'tinyurl.com',
            'alias' => $request->input('alias'),
            'description' => $request->input('description')
        ];

        $response = Http::withToken(env('TINY_TOKEN'))
            ->post('https://api.tinyurl.com/create', $body);

        if ($response->successful()) {
            $tinyUrl = $response->json('data.tiny_url');

            return response()->json([
                'url' => $tinyUrl
            ], 200, [], JSON_UNESCAPED_SLASHES);
        }

        return response()->json(['error' => 'Failed to shorten URL'], $response->status());
    }
}
