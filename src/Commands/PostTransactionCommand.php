<?php

namespace BluebeansSystems\Nephos\Commands;

use Illuminate\Console\Command;

class PostTransactionCommand extends Command
{
    /**
     * @var
     */
    public $subscription;
    /**
     * @var
     */
    public $transactionrefno;
    /**
     * @var
     */
    public $module;
    /**
     * @var
     */
    public $user;
    /**
     * @var
     */
    public $status;
    /**
     * @var
     */
    public $posted_by;
    /**
     * @var
     */
    public $posted_at;
    /**
     * @var
     */
    public $glaccount;
    /**
     * @var
     */
    public $client;
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
    public $accountentry;
    /**
     * @var
     */
    public $transamount;
    /**
     * @var
     */
    public $transamountdue;
    /**
     * @var
     */
    public $paymentform;
    /**
     * @var
     */
    public $transactiontag;
    /**
     * @var
     */
    public $explanation;

    /**
     * Create a new command instance.
     * @param $subscription
     * @param $transactionrefno
     * @param $module
     * @param $user
     * @param $status
     * @param $posted_by
     * @param $explanation
     * @param $posted_at
     * @param $glaccount
     * @param $client
     * @param $accountclass
     * @param $accounttype
     * @param $accountentry
     * @param $transamount
     * @param $transamountdue
     * @param $paymentform
     * @param $transactiontag
     */
    public function __construct($subscription, $transactionrefno, $module, $user, $status, $posted_by, $explanation, $posted_at,
        $glaccount, $client, $accountclass, $accounttype, $accountentry, $transamount, $transamountdue, $paymentform, $transactiontag)
    {

        $this->subscription = $subscription;
        $this->transactionrefno = $transactionrefno;
        $this->module = $module;
        $this->user = $user;
        $this->status = $status;
        $this->posted_by = $posted_by;
        $this->explanation = $explanation;
        $this->posted_at = $posted_at;
        $this->glaccount = $glaccount;
        $this->client = $client;
        $this->accountclass = $accountclass;
        $this->accounttype = $accounttype;
        $this->accountentry = $accountentry;
        $this->transamount = $transamount;
        $this->transamountdue = $transamountdue;
        $this->paymentform = $paymentform;
        $this->transactiontag = $transactiontag;
    }
}
