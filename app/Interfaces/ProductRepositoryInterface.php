<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function list($params = null);
    public function create($details);
}
