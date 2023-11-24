<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function list()
    {
        return Category::all();
    }

    public function findById(int $categoryId)
    {
        return Category::query()->findOrFail($categoryId);
    }
}
