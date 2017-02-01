<?php

namespace BluebeansSystems\Nephos\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model {

	protected $fillable = ['subscription','controlno','glaccount','client','seqno','transactionrefno','module','transtype','accountclass','accounttype','accountentry','transamount','transamountdue','paymentform','transactiontag'];

	protected $table = 'transaction_details';

}
