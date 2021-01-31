<?php

namespace App\Http\Controllers\API\Merchants;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Auth\Access\AuthorizationException;

class ProductController extends Controller
{

    public function index()
    {
        return response()->json(['data' => auth_factory('user')->products]);
    }

    public function show(Product $product)
    {
        if (!auth_factory('user')->products->contains($product->id)) {
            throw (new AuthorizationException());
        }

        return response()->json(['data' => $product]);
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        $product = auth_factory('user')->products()->create($validated);

        return response()->json([
            'message' => 'Product Created Successfully',
            'data' => $product
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return response()->json(
            [
                'message' => 'Product Updated Successfully',
                'data' => $product
            ]
        );
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(
            [
                'message' => 'Product Deleted Successfully',
            ]
        );
    }
}
