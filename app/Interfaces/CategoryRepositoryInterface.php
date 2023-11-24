<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    public function list();
    public function findById(int $categoryId);
    
}
