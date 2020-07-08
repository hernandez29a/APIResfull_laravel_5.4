<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {

        /**
         * Obtenemos una lista de productos 
         * 
         * luego buscamos los productos que tengan transacciones usando el 
         * metodo whereHas
         * 
         * y mostramos ese listado con el with y el get
         */

        $transactions = $category->products()
        ->whereHas('transactions')
        ->with('transactions')
        ->get()
        ->pluck('transactions')
        ->collapse();

        return $this->showAll($transactions);
    }

    
}
