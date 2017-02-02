<?php

namespace BluebeansSystems\Nephos\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionSummary extends Model {

	protected $fillable = ['subscription','controlno','transactionrefno','module','transtype','client','docno','batchno','user','status','posted_by','explanation','posted_at','is_fo'];
	
	protected $table    = 'transaction_summary';

    protected $dates    = ['posted_at'];

    public function details()
    {
        return $this->hasMany('App\TransactionDetails','controlno','controlno');
    }

    public function getTag()
    {
        return $this->hasOne('App\TransactionTags','id','status');
    }
}
