<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerSellerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        /**
         * obtenemos los vendedores de la tabla producto por medio de la 
         * relacion de transacciones y obtenemos esa lista con el metodo get
         */

         /**
          * al obtener esa lista usando pluck con los vendedores de esos productos
          *vamos a traer una lista con vendedores repetidos 
          */

        /**
         * co nel metodo unique mostramos solo un vendedor pero esto dejara espacios vacios 
         * que los quitaremos con el metoso valuess
         */
        $seller = $buyer->transactions()->with('product.seller')
        ->get()
        ->pluck('product.seller')
        ->unique('id')
        ->values();
        

        return $this->showAll($seller);
    }
}
