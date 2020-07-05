<?php

namespace App;

use App\Transactions;

class Buyer extends Model
{
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
