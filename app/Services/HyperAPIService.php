<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HyperAPIService
{
    private string $baseUrl;
    private string $token;

    public function __construct()
    {
        $this->baseUrl  = config('hyper_api.base_url');
        $this->token    = config('hyper_api.token');
    }

    public function getProducts(int $page = 1, int $perPage = 20): array
    {
        try {
            $queryParams = ['page' => $page, 'pageSize' => $perPage];
            $response = Http::withHeaders($this->getDefaultHeaders())
                ->timeout(10)
                ->withQueryParameters($queryParams)
                ->post("{$this->baseUrl}/Products/List");
            $result = $response->json();

            if ($response->failed()) {
                $errorMessage = $result ?? "Hyper API üzerinden ürünler getirilirken bir hata oluştu.";
                return ["success" => false, "message" => $errorMessage];
            }

            return $response->json();
        } catch (ConnectionException $e) {
            Log::error('Hyper API ürün listesi isteği sırasında beklenmeyen bir hata oluştu.', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            $errorMessage = "Hyper API isteğinde beklenmeyen bir hata oluştu.";
            return ["success" => false, "message" => $errorMessage];
        }
    }

    private function getDefaultHeaders(): array
    {
        return [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer '.$this->token,
        ];
    }
}
