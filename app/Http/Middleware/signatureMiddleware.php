<?php

namespace App\Http\Middleware;

use Closure;

class signatureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $header = "x-Name")
    {
        $response = $next($request);

        /**
         * esta middleware se ejecutara despues de la peticion que se haga 
         * ya que primero se ejecuta la respuesta y luego se ejecuta el resto 
         */
        $response->headers->set($header, config('app.name'));

        return $response;
    }
}
