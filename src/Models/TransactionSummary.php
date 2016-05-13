<?php

namespace BluebeansSystems\Nephos\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionSummary extends Model {

	protected $fillable = ['subscription','controlno','transactionrefno','module','user','status','posted_by','explanation','posted_at'];
	
	protected $table    = 'transaction_summary';

    protected $dates    = ['posted_at'];

}
