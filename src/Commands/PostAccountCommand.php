<?php

namespace BluebeansSystems\Nephos\Commands;

use Illuminate\Console\Command;

class PostAccountCommand extends Command
{
    /**
     * @var
     */
    public $subscription;
    /**
     * @var
     */
    public $accountclass;
    /**
     * @var
     */
    public $accounttype;
    /**
     * @var
     */
    public $client;
    /**
     * @var
     */
    public $user;
    /**
     * @var
     */
    public $controlno;
    /**
     * @var
     */
    public $accountentry;
    /**
     * @var
     */
    public $transamount;
    /**
     * @var
     */
    public $status;

    /**
     * Create a new command instance.
     *
     * @param $subscription
     * @param $accountclass
     * @param $accounttype
     * @param $client
     * @param $user
     * @param $controlno
     * @param $accountentry
     * @param $transamount
     * @param $status
     */
    public function __construct($subscription, $accountclass, $accounttype, $client, $user,
                                $controlno, $accountentry,
                                $transamount, $status)
    {
        $this->subscription = $subscription;
        $this->accountclass = $accountclass;
        $this->accounttype = $accounttype;
        $this->client = $client;
        $this->user = $user;
        $this->controlno = $controlno;
        $this->accountentry = $accountentry;
        $this->transamount = $transamount;
        $this->status = $status;
    }
}
