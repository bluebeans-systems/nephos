<?php

namespace BluebeansSystems\Nephos\Models;

use Illuminate\Database\Eloquent\Model;

class GlControls extends Model {

	protected $fillable = ['subscription','accountclass','accounttype','accountentry','glaccount','glentrytype','user'];

	protected $table    = 'glcontrols';

    public function getAccountEntry()
    {
        return $this->hasOne('BluebeansSystems\Nephos\Models\AccountEntry','id','accountentry');
    }

    public function getGlAccount()
    {
        return $this->hasOne('BluebeansSystems\Nephos\Models\GlAccounts','glaccount','glaccount');
    }

    public function getAccountType()
    {
        return $this->hasOne('BluebeansSystems\Nephos\Models\AccountTypes','id','accounttype');
    }

    public function getGlEntryType()
    {
        return $this->hasOne('BluebeansSystems\Nephos\Models\GlEntryType','id','glentrytype');
    }
}
