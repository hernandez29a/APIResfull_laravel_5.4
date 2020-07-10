<?php

use App\Buyer;
use App\Product;
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transformers\TransactionTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    public $transformer = TransactionTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'quantity',
        'buyer_id',
        'product_id',
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }

}
