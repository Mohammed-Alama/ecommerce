<?php

namespace App\Policies;

use App\Models\Merchant;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function update(Merchant $user, Product $product)
    {
        return $product->merchant_id == $user->id;
    }

    public function delete(Merchant $user, Product $product)
    {
        return $product->merchant_id == $user->id;
    }
}
