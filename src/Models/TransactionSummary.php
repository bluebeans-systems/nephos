<?php

namespace BluebeansSystems\Nephos\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionSummary extends Model {

	protected $fillable = ['subscription','controlno','transactionrefno','module','transtype','client','docno','batchno','user','status','posted_by','explanation','transaction_at','posted_at','is_fo'];
	
	protected $table    = 'transaction_summary';

    protected $dates    = ['transaction_at','posted_at'];

    public function details()
    {
        return $this->hasMany('BluebeansSystems\Nephos\Models\TransactionDetails','controlno','controlno');
    }

    public function getTag()
    {
        return $this->hasOne('BluebeansSystems\Nephos\Models\TransactionTags','id','status');
    }
}
