<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductRepository implements ProductRepositoryInterface
{

    public function list($params = null)
    {
        $products = Product::query();
        if (!empty($params->category)) {
            $category = $params->category;
            $products->whereHas('category', function ($query) use ($category) {
                $query->where('id', $category);
            });
        }
        if (!empty($params->sort_by_price)) {
            $products->orderBy('price', $params['sort_by_price']);
        } else {
            $products->orderBy('created_at', 'desc');
        }
        return $products->get();
    }
    public function create($details)
    {
        $product = Product::create($details);
        if (is_array($details) && array_key_exists('image', $details)) {
            $image = $details['image'];
            $input['img_url'] = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/product');

            if (!Storage::exists($destinationPath)) {
                Storage::disk('public')->makeDirectory($destinationPath);
            }
            $image->move($destinationPath, $input['img_url']);
            $product->update([
                'image' => $input['img_url']
            ]);
        }

        return $product->refresh();
    }
}
