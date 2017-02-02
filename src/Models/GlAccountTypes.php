<?php

namespace BluebeansSystems\Nephos\Models;

use Illuminate\Database\Eloquent\Model;

class GlAccountTypes extends Model
{
    protected $table    = 'glaccount_types';

    public function getGlAccounts()
    {
        return $this->hasMany('BluebeansSystems\Nephos\Models\GlAccounts','gltype','id');
    }

    public function getGlDetailAccounts()
    {
        return $this->getGlAccounts()->where('gllevel',2)->orderBy('description')->get();
    }
}
