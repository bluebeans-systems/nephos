<?php

namespace BluebeansSystems\Nephos\Models;

use Illuminate\Database\Eloquent\Model;

class GlAccounts extends Model {

    protected $fillable = ['subscription','gltype','glsummary','glaccount','description','gllevel','status','user'];

    protected $table    = 'glaccounts';

    public function getGlAccountType()
    {
        return $this->hasOne('BluebeansSystems\Nephos\Models\GlAccountTypes','id','gltype');
    }

    public function isSummary()
    {
        return $this->gllevel==1 ? true : false;
    }

    public function isDetail()
    {
        return $this->gllevel==2 ? true : false;
    }

    public function isAsset()
    {
        return $this->getGlAccountType->code=="asset" ? true : false;
    }

    public function isLiability()
    {
        return $this->getGlAccountType->code=="liability" ? true : false;
    }

    public function isEquity()
    {
        return $this->getGlAccountType->code=="equity" ? true : false;
    }

    public function isRevenue()
    {
        return $this->getGlAccountType->code=="revenue" ? true : false;
    }

    public function isExpense()
    {
        return $this->getGlAccountType->code=="expense" ? true : false;
    }

    public function isNetIncome()
    {
        return $this->getGlAccountType->code=="net-income" ? true : false;
    }
}
