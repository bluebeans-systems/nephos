<?php

namespace BluebeansSystems\Nephos\Models;

use Illuminate\Database\Eloquent\Model;

class AccountClass extends Model {

	protected $table = 'account_classes';

    public function getAccountTypes()
    {
        return $this->hasMany('BluebeansSystems\Nephos\Models\AccountTypes','accountclass','id');
    }

}
