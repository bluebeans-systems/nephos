<?php

namespace BluebeansSystems\Nephos\Models;

use Illuminate\Database\Eloquent\Model;

class GlTransactionDetails extends Model {

	protected $fillable = ['subscription','controlno','accountclass','accounttype','accountentry','client','glaccount','glamount'];

	protected $table = 'gl_details';

}
