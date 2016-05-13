<?php

namespace BluebeansSystems\Nephos\Facades;


use Illuminate\Support\Facades\Facade;

class Nephos extends Facade {

    /**
     * Return facade accessor
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'nephos';
    }
}