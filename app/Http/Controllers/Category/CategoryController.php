<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\CategoryTransformer;

class CategoryController extends ApiController
{

    public function __construct()
    {
        //parent::__construct();

        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('transform.input:' . CategoryTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return $this->showAll($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * Verificar si el usuario es administrador y tiene permisos como tal
         */
        $this->allowedAdminAction();

        $reglas = [
            'name' => 'required',
            'description' => 'required'
        ];

        //validamos las reglas para incluir un usuario
        $this->validate($request, $reglas);

        $category = Category::create($request->all());

        return $this->showOne($category, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        /**
         * Verificar si el usuario es administrador y tiene permisos como tal
         */
        $this->allowedAdminAction();
        $category->fill($request->only([
            'name',
            'description'
        ]));

        if($category->isClean()){
            return $this->errorResponse('Debe especificar al menos un valor difetente para actualizar', 422);
        }

        $category->save();

        return $this->showOne($category);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        /**
         * Verificar si el usuario es administrador y tiene permisos como tal
         */
        $this->allowedAdminAction();
        
        $category->delete();

        return $this->showOne($category);
    }
}
