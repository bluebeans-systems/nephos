<?php

namespace BluebeansSystems\Nephos\Models;

use Illuminate\Database\Eloquent\Model;

class Accounts extends Model {

	protected $fillable = ['subscription','accountno','accountclass','accounttype','client','transactionrefno','user'];

	protected $table = 'accounts';

    public function getAccountType()
    {
        return $this->hasOne('BluebeansSystems\Nephos\Models\AccountTypes','id','accounttype');
    }

    public function getAccountSummary()
    {
        return $this->hasMany('BluebeansSystems\Nephos\Models\AccountSummary','accountno','accountno');
    }

    public function getAccountDetails()
    {
        return $this->hasMany('BluebeansSystems\Nephos\Models\AccountDetails','accountno','accountno');
    }

    public function checkAccount($subscription, $refno, $accountclass, $accounttype, $id)
    {
        $account    = $this->where('subscription',$subscription)
                           ->where('accountclass',$accountclass)
                           ->where('accounttype',$accounttype)
                           ->where('client',$id)
                           ->first();

        $accountno = null;

        // If account exists, get account no., else get the last number
        if(!is_null($account))
        {
            $accountno  = $account->accountno;
        }
        else
        {
            $accountno  = $this->createNewAccount([
                            'subscription'  => $subscription,
                            'accountclass'  => $accountclass,
                            'accounttype'   => $accounttype,
                            'refno'         => $refno,
                            'id'            => $id,
                            'user'          => auth()->user()->id
                            ]);
        }

        return $accountno;
    }

    private function createNewAccount($array)
    {

        // Create New Account if not exists
        $account    = new Accounts();

        $accountno    = $account->where('subscription',$array['subscription'])
                                ->max('accountno') + 1;

        $account->subscription         = $array['subscription'];
        $account->accountno            = $accountno;
        $account->accountclass         = $array['accountclass'];
        $account->accounttype          = $array['accounttype'];
        $account->client               = $array['id'];
        $account->transactionrefno     = $array['refno'];
        $account->user                 = $array['user'];
        $account->save();

        return $accountno;
    }

}
