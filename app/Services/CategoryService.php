<?php

namespace App\Services;

use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    /**
     * @param array $payload
     * @throws Exception
     */
    public function create(array $payload): void
    {
        DB::beginTransaction();

        try {
            Category::create([
                'name' => $payload['name'],
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception(__('category.create_failed'));
        }

        DB::commit();
    }

    /**
     * @param Category $category
     * @param array $payload
     * @throws Exception
     */
    public function update(Category $category, array $payload): void
    {
        DB::beginTransaction();

        try {
            $category->update([
                'name' => $payload['name'],
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception(__('category.update_failed'));
        }

        DB::commit();
    }

    /**
     * @throws Exception
     */
    public function delete($category): void
    {
        /* @var Category $category */
        if ($category->products()->exists()) {
            throw new Exception(__('category.attached_to_products'));
        }

        DB::beginTransaction();

        try {
            $category->delete();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception(__('category.update_failed'));
        }

        DB::commit();
    }
}
