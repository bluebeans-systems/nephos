<?php

namespace BluebeansSystems\Nephos\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $table    = 'transaction_types';

    public function getCategories()
    {
        return $this->hasMany('BluebeansSystems\Nephos\Models\TransactionCategory','transaction_type','id');
    }
}
