<?php

namespace App\Policies;

use App\User;
use App\Buyer;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuyerPolicy
{
    use HandlesAuthorization, AdminActions;

    /**
     * Determine whether the user can view the buyer.
     *
     * @param  \App\User  $user
     * @param  \App\Buyer  $buyer
     * @return mixed
     */
    public function view(User $user, Buyer $buyer)
    {
        /**
         * Verificar que el usuario sea el comprador 
         * esto significa que solo este comprador puede ver esta lista
         */
        return $user->id === $buyer->id;
    }

    
    /**
     * Determina cuando el usuario puede comprar algo.
     *
     * @param  \App\User  $user
     * @param  \App\Buyer  $buyer
     * @return mixed
     */
    public function purchase(User $user, Buyer $buyer)
    {
        /**
         * Verificar que el usuario sea el comprador para comprar
         * esto significa que solo este usuario puede comprar productos 
         */
        return $user->id === $buyer->id;
    }
}
