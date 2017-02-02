<?php

namespace BluebeansSystems\Nephos\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model {

	protected $fillable = ['subscription','controlno','glaccount','client','seqno','transactionrefno','module','transtype','accountclass','accounttype','accountentry','transamount','transamountdue','paymentform','transactiontag'];

	protected $table = 'transaction_details';

    public function transactionSummary()
    {
        return $this->hasOne('BluebeansSystems\Nephos\Models\TransactionSummary','controlno','controlno');
    }

    public function getGlAccount()
    {
        return $this->hasOne('BluebeansSystems\Nephos\Models\GlAccounts','glaccount','glaccount');
    }

    public function getAmountFormat($amount)
    {
        if($amount < 0) {
            $new_amt    = '('.number_format($amount * -1, 2) .')';
        } else {
            $new_amt    = number_format($amount,2);
        }

        return $new_amt;
    }
}
