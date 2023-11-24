<?php

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function list()
    {
        return Product::all();
    }

    public function findById(int $productId)
    {
        return Product::query()->findOrFail($productId);
    }
    public function create(array $details)
    {
        return Product::create($details);
    }
}
