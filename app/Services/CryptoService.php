<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CryptoService
{
    protected $apiUrl = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('COINMARKETCAP_API_KEY');
    }

    public function getCryptoData($limit = 10)
    {
        $response = Http::withHeaders([
            'X-CMC_PRO_API_KEY' => $this->apiKey
        ])->get($this->apiUrl, [
            'limit' => $limit,
            'convert' => 'USD'
        ]);

        if ($response->successful()) {
            return $response->json()['data'];
        }
        
        return [];
    }
}
