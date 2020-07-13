<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class BuyerTransactionController extends ApiController
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
         * en la variable seller se guardara las transacciones que 
         * tenga un vendedor en la tabla de productos
         */
        $transactions = $buyer->transactions;

        return $this->showAll($transactions);
    }
}
