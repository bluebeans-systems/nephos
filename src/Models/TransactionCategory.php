<?php

namespace BluebeansSystems\Nephos\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionCategory extends Model
{
    protected $table    = 'transaction_categories';

    public function getType()
    {
        return $this->hasOne('BluebeansSystems\Nephos\Models\TransactionType','id','transaction_type');
    }

    public function isIncome()
    {
        return $this->getType->code=="income" ? true : false;
    }

    public function isExpense()
    {
        return $this->getType->code=="expense" ? true : false;
    }
}
