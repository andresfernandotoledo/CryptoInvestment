<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CryptoController extends Controller
{
    private $apiKey = 'f1d48922-23b2-4f2d-9351-6fcb105d87da';

    /**
     * Página principal de criptomonedas
     */
    public function showCryptoPage()
    {
        return view('crypto', ['apiUrl' => route('getChartData'), 'cryptoListUrl' => route('getCryptoList')]);
    }

    /**
     * Obtener datos de una criptomoneda específica
     */
    public function getChartData(Request $request)
    {
        $cryptoSymbol = strtoupper($request->query('crypto', 'BTC'));

        // Llamar a la API para obtener todas las criptos
        $response = Http::withHeaders([
            'X-CMC_PRO_API_KEY' => $this->apiKey,
        ])->get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest', [
            'start' => 1,
            'limit' => 5000,  // Obtener hasta 5000 criptos
            'convert' => 'USD',
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'No se pudieron obtener los datos'], 500);
        }

        $data = collect($response->json()['data']);

        // Buscar la criptomoneda seleccionada
        $cryptoData = $data->firstWhere('symbol', $cryptoSymbol);

        if (!$cryptoData) {
            return response()->json(['error' => 'Criptomoneda no encontrada'], 404);
        }

        return response()->json([
            'timestamp' => now()->toDateTimeString(),
            'price' => $cryptoData['quote']['USD']['price'],
            'percent_change' => $cryptoData['quote']['USD']['percent_change_24h'],
            'volume' => $cryptoData['quote']['USD']['volume_24h'],
        ]);
    }

    /**
     * Obtener la lista de criptomonedas disponibles
     */
    public function getCryptoList()
    {
        $response = Http::withHeaders([
            'X-CMC_PRO_API_KEY' => $this->apiKey,
        ])->get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest', [
            'start' => 1,
            'limit' => 5000,
            'convert' => 'USD',
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'No se pudo obtener la lista de criptos'], 500);
        }

        $cryptoList = collect($response->json()['data'])->map(function ($crypto) {
            return [
                'symbol' => $crypto['symbol'],
                'name' => $crypto['name'],
            ];
        });

        return response()->json($cryptoList);
    }
}
