<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        /**
         * con el id de buyer , buscamos en la tabla de transacciones 
         * el producto que haya sido vendido por este vendedor y 
         * mostramos esa lista de productos
         */
        $products = $buyer->transactions()->with('product')
        ->get()
        ->pluck('product');

        return $this->showAll($products);
    }

    
}
