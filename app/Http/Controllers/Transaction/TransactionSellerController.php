<?php

namespace App\Http\Controllers\Transaction;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TransactionSellerController extends ApiController
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
    public function index(Transaction $transaction)
    {
        /**
         * en la variable seller se guardara las transacciones que 
         * tenga un vendedor en la tabla de productos
         */
        $seller = $transaction->product->seller;

        return $this->showOne($seller);
    }

   
}
