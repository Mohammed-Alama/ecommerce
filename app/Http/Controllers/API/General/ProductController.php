<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function __invoke()
    {
        return response()->json(['data' => Product::active()->get()]);
    }
}
