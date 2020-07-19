<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerCategoryController extends ApiController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only('index');
        //declaramos la policy de buyer
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
         * obtenemos las categorias de la tabla producto por medio de la 
         * relacion de transacciones y obtenemos una serie de listas con el metodo get
         */

         /**
          * con el metodo pluck no traemos un conjunto de listas de cada producto que posee la categoria 
          que esta asociado a ese comprador y con el metodo colapse unificamos esas listas en 
          una unica lista de productos
          */

        /**
         * co nel metodo unique mostramos solo un producto pero esto dejara espacios vacios 
         * que los quitaremos con el metoso values
         */
        $categories = $buyer->transactions()->with('product.categories')
        ->get()
        ->pluck('product.categories')
        ->collapse()
        ->unique('id')
        ->values();
        

        return $this->showAll($categories);
    }    
}
