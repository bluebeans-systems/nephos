<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrontOfficeTransaction extends Model {

    protected $table    = 'front_office_transactions';

    protected $fillable = ['controlno','client','transactionrefno','transactiontype','receiptno','user'];
}
