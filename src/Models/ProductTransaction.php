<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model {

    protected $table    = 'product_transactions';

    protected $fillable = ['controlno','transactionrefno','transactiontype','entrytype','product','pricetype','quantity','amount','remarks','user'];
}
