<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('scope:read-general')->only('show');
        $this->middleware('can:view,buyer')->only('show');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Verificar si el usuario es administrador y tiene permisos como tal
         */
        $this->allowedAdminAction();
        /**
         * obtener a los usuarios que tengan transacciones
         * y mostrarlos en el arreglo de data
         * 
        */
        $compradores = Buyer::has('transactions')->get();

        return $this->showAll($compradores);
    }

   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
        //$comprador = Buyer::has('transactions')->findOrFail($id);

        //return response()->json(['data' => $comprador],200);
        return $this->showOne($buyer);
    }

    
}
