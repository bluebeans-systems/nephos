<?php

namespace BluebeansSystems\Nephos;

use BluebeansSystems\Nephos\Commands\PostAccountCommand;
use BluebeansSystems\Nephos\Commands\PostTransactionCommand;

class Nephos {

    /**
     * Post Transaction
     *
     * @param $data
     * @return mixed
     */
    public function postTransaction($data)
    {
        return $this->dispatchFrom(PostTransactionCommand::class, $data);
    }

    /**
     * Post Account Transaction
     * @param $data
     */
    public function postAccount($data)
    {
        $this->dispatchFrom(PostAccountCommand::class, $data);
    }

}