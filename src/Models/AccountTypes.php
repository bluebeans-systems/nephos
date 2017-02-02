<?php

namespace BluebeansSystems\Nephos\Models;

use Illuminate\Database\Eloquent\Model;

class AccountTypes extends Model {

	protected $fillable = ['subscription','module','accountclass','description','shortdesc','status','user'];

	protected $table = 'account_types';

    /**
     *
     * Used to get all the GL controls associated to an account type
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getGlControls()
    {
        return $this->hasMany('BluebeansSystems\Nephos\Models\GlControls','accounttype','id');
    }


    /**
     * For single result, not recommended for multiple accounting entries
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getGlControl()
    {
        return $this->hasOne('BluebeansSystems\Nephos\Models\GlControls','accounttype','id');
    }

}
