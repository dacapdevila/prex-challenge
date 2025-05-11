<?php

namespace App\Services;

use App\Exceptions\ExternalApiException;
use Illuminate\Support\Facades\Http;

class GiphyService
{
    public function __construct(private ?string $apiKey = null)
    {
        $this->apiKey = $apiKey ?: config('services.giphy.key');
    }

    /**
     * @return array Giphy's JSON decode
     *
     * @throws ExternalApiException
     */
    public function search(string $query, int $limit = 25, int $offset = 0): array
    {
        return $this->request('search', [
            'q' => $query,
            'limit' => $limit,
            'offset' => $offset,
        ]);
    }

    /**
     * @throws ExternalApiException
     */
    public function show(string $id): array
    {
        return $this->request($id);
    }

    /**
     * @throws ExternalApiException
     */
    private function request(string $endpoint, array $params = []): array
    {
        $query = array_merge(['api_key' => $this->apiKey], $params);

        $resp = Http::baseUrl('https://api.giphy.com/v1/gifs')
            ->get($endpoint, $query);

        if ($resp->failed()) {
            throw new ExternalApiException('Giphy error: '.$resp->status());
        }

        return $resp->json();
    }
}
