<?php

use App\Product;
namespace App;

//las clase de Vendedor extiende directamente de usuario
class Seller extends User
{
    public function products()
    {
        return $this ->hasMany(Product::class);
    }
}
