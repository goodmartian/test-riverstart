<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrCreateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    /**
     * @return AnonymousResourceCollection
     */
    public function getAllProducts()
    {
        $products = $this->productService->getProducts();

        return ProductResource::collection($products);
    }

    /**
     * @param UpdateOrCreateProductRequest $request
     * @return JsonResponse
     */
    public function create(UpdateOrCreateProductRequest $request)
    {
        try {
            $this->productService->create($request->only([
                'name',
                'description',
                'price',
                'quantity',
                'categories',
            ]));
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => __('product.created')
        ]);
    }

    /**
     * @param Product $product
     * @param UpdateOrCreateProductRequest $request
     * @return JsonResponse
     */
    public function update(Product $product, UpdateOrCreateProductRequest $request)
    {
        try {
            $this->productService->update($product, $request->only([
                'name',
                'description',
                'price',
                'quantity',
                'categories',
            ]));
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => __('product.updated')
        ]);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function delete(Product $product)
    {
        try {
            $this->productService->delete($product);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => __('product.deleted')
        ]);
    }
}
