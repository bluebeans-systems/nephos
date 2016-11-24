<?php

namespace BluebeansSystems\Nephos\Models;

use Illuminate\Database\Eloquent\Model;

class GlTransactionSummary extends Model {

	protected $fillable = ['subscription','controlno','client','transactionrefno'];

	protected $table = 'gl_summary';

}
