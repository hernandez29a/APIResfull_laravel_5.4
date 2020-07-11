<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

//Archivo usado para mostrar las respuyestas de tipo json al ApiController
trait ApiResponser
{
    /**
     * metodo para retornar un mensaje de accion realizada
     */
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    /**
     * metodo para retornar un mensaje de error
     */

    protected function errorResponse($message, $code)
    {
        return response()->json(['error'=> $message, 'code'=> $code], $code);
    }

    /**
     * Metodo para mostrar una lista de resultados
     */

    protected function showAll(Collection $collection, $code = 200)
    {
        //return $this->successResponse(['data' => $collection], $code);

        if ($collection->isEmpty()) {
			return $this->successResponse(['data' => $collection], $code);
		}

        $transformer = $collection->first()->transformer;
        
        $collection = $this->filterData($collection, $transformer);
        $collection = $this->sortData($collection, $transformer);
        $collection = $this->paginate($collection);
        $collection = $this->transformData($collection, $transformer);
        $collection = $this->cacheResponse($collection);

		return $this->successResponse($collection, $code);
    }

    /**
     * metoso para mostrar un resultado determinado
     */
    protected function showOne(Model $instance, $code = 200)
    {
        //return $this->successResponse(['data' => $instance], $code);
        $transformer = $instance->transformer;
		$instance = $this->transformData($instance, $transformer);

		return $this->successResponse($instance, $code);
    }

    /**
     * metodo para mostrar mensajes
     */

    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }


    /**
     * metodo para filtrar los campos por una instruccion en la ruta
     */
    protected function sortData(Collection $collection, $transformer)
	{
		if (request()->has('sort_by')) {
			$attribute =$transformer::originalAttribute(request()->sort_by);

			$collection = $collection->sortBy->{$attribute};
		}
		return $collection;
    }
    
    /*protected function filterData(Collection $collection, $transformer)
	{
		foreach (request()->query() as $query => $value) {
			$attribute = $transformer::originalAttribute($query);

			if (isset($attribute, $value)) {
				$collection = $collection->where($attribute, $value);
			}
		}

		return $collection;
    }*/
    
    //funcion para buscan un elemento especifico 
    protected function filterData(Collection $collection, $transformer)
    {
        foreach (request()->query() as $query => $value) {
            $attribute = $transformer::originalAttribute($query);
 
            if (isset($attribute, $value)) {
//                $collection = $collection->where($attribute, $value);
                $collection = $collection->filter(function($item) use ($attribute, $value){
                    return false !== stristr($item[$attribute], $value);
                });
            }
        }
        return $collection;
    }


    /**
     * Paginar los resultados
     */
    protected function paginate(Collection $collection)
	{
        $rules = [
			'per_page' => 'integer|min:2|max:50'
		];

        Validator::validate(request()->all(), $rules);
        
		$page = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 15;
        
        if (request()->has('per_page')) {
			$perPage = (int) request()->per_page;
		}

		$results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

		$paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
			'path' => LengthAwarePaginator::resolveCurrentPath(),
		]);

		$paginated->appends(request()->all());

		return $paginated;
	}



    /**
     * Metodo para transformar los campos de la base de datos de entrada 
     */
    protected function transformData($data, $transformer)
	{
		$transformation = fractal($data, new $transformer);

		return $transformation->toArray();
    }
    
    /**
     * Guardar en el cache la peticion por 30 segundos 
     */
    protected function cacheResponse($data)
	{
        $url = request()->url();
        $queryParams = request()->query();

		ksort($queryParams);

		$queryString = http_build_query($queryParams);

		$fullUrl = "{$url}?{$queryString}";

        //colocar el cache por 15 segundos
		return Cache::remember($fullUrl, 15/60, function() use($data) {
			return $data;
		});
	}
}