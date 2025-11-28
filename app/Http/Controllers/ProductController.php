<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getProducts(Request $request): JsonResponse
    {
        $params = $request->validate([
            'page' => 'sometimes|integer|min:0',
            'per_page' => 'sometimes|integer|min:1|max:100',
        ]);

        $result = $this->productService->getProducts($params["page"], $params["per_page"]);
        return response()->json($result, $result['success'] ? 200 : 400);
    }
}
