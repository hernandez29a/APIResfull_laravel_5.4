<?php

namespace App;

use App\Transactions;

class Buyer extends User
{
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
