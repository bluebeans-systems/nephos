<?php

namespace BluebeansSystems\Nephos\Controllers;

use App\Http\Controllers\Controller;
use BluebeansSystems\Nephos\Facades\Nephos;

class PostTransactionController extends Controller {

    public function index()
    {
        return Nephos::create();
    }

}