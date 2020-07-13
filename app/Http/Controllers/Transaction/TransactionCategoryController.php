<?php

namespace App\Http\Controllers\Transaction;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TransactionCategoryController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Transaction $transaction)
    {

        /**
         * en categorias se guardara lo siguite:
         * obtener las transacciones de productos que tiene categorias
         * para luego obtener esas mismas y mostrarlas
         */
        $categories = $transaction->product->categories;

        return $this->showAll($categories);
    }
}
