<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class ProductService
{
    private HyperAPIService $hyperAPIService;
    private int $cacheTTL;

    public function __construct(HyperAPIService $hyperAPIService)
    {
        $this->hyperAPIService = $hyperAPIService;
        $this->cacheTTL = (int) config('hyper_api.cache_ttl', 60);
    }

    public function getProducts(int $page = 1, int $perPage = 20): array
    {
        $cacheKey = "hyper_products_page_{$page}_per_{$perPage}";
        return Cache::remember(
            $cacheKey,
            $this->cacheTTL,
            fn () => $this->hyperAPIService->getProducts($page, $perPage)
        );
    }
}
