<?php

namespace BluebeansSystems\Nephos\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model {

	protected $fillable = ['subscription','controlno','glaccount','client','transactionrefno','accountclass','accounttype','accountentry','transamount','transamountdue','paymentform','transactiontag','user'];

	protected $table = 'transaction_details';

}
