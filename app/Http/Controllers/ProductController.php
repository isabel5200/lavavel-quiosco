<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Get products
    public function index()
    {
        return new ProductCollection(Product::where('available', 1)->orderBy('id', 'DESC')->get());
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Product $product)
    {
        //
    }

    // Update available status of the product
    public function update(Request $request, Product $product)
    {
        $product->available = 0;
        $product->save();

        return [
            'product' => $product
        ];
    }

    public function destroy(Product $product)
    {
        //
    }
}
