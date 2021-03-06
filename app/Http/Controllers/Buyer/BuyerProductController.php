<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerProductController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only('index');
        $this->middleware('can:view,buyer')->only('index');
    }
    
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
