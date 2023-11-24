<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function list();
    public function findById(int $productId);
    public function create(array $details);
    
}
