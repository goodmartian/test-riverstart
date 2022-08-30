<?php

namespace App\Services;

use App\Models\Product;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getProducts(): LengthAwarePaginator
    {
        return QueryBuilder::for(Product::class)
            ->allowedFilters([
                'name',
                AllowedFilter::scope('price', 'wherePriceBetween'),
                AllowedFilter::exact('status', 'status_id'),
                AllowedFilter::exact('categories', 'categories.id'),
            ])
            ->with(['categories'])
            ->orderBy('created_at', 'DESC')
            ->paginate(15);
    }

    /**
     * @param array $payload
     * @return Product
     * @throws Exception
     */
    public function create(array $payload): Product
    {
        DB::beginTransaction();

        try {
            $product = Product::create([
                'name' => $payload['name'],
                'description' => $payload['description'],
                'price' => $payload['price'],
                'quantity' => $payload['quantity'],
            ]);

            $product->categories()->attach($payload['categories']);
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception(__('product.create_failed'));
        }

        DB::commit();

        return $product;
    }

    /**
     * @param Product $product
     * @param array $payload
     * @return Product
     * @throws Exception
     */
    public function update(Product $product, array $payload): Product
    {
        DB::beginTransaction();

        try {
            $product->update([
                'name' => $payload['name'],
                'description' => $payload['description'],
                'price' => $payload['price'],
                'quantity' => $payload['quantity'],
            ]);

            $product->categories()->sync($payload['categories']);
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception(__('product.update_failed'));
        }

        DB::commit();

        return $product;
    }

    /**
     * @throws Exception
     */
    public function delete($product): void
    {
        DB::beginTransaction();

        try {
            /* @var Product $product */
            $product->categories()->detach();
            $product->delete();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception(__('product.update_failed'));
        }

        DB::commit();
    }
}
