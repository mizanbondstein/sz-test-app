<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Interfaces\ProductRepositoryInterface;
use App\Traits\RequestResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use RequestResponse;
    private ProductRepositoryInterface $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function index(Request $request)
    {
        try {
            $productList = $this->productRepository->list($request);
            return $this->successResponse('Product List', $productList);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
    public function store(StoreProductRequest $request)
    {
        try {
            $details = [
                'name' => $request->name,
                'price' =>  $request->price,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'image' => $request->image
            ];
            $product = $this->productRepository->create($details);
            return $this->successResponse('Product List', $product);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
