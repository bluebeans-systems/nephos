<?php

namespace BluebeansSystems\Nephos;

use BluebeansSystems\Nephos\Models\AccountDetails;
use BluebeansSystems\Nephos\Models\Accounts;
use BluebeansSystems\Nephos\Models\AccountSummary;
use BluebeansSystems\Nephos\Models\TransactionDetails;
use BluebeansSystems\Nephos\Models\TransactionSummary;
use BluebeansSystems\Nephos\Models\GlTransactionDetails;
use BluebeansSystems\Nephos\Models\GlTransactionSummary;
use Illuminate\Support\Facades\DB;

class Nephos {

    /**
     * @var TransactionSummary
     */
    private $transactionSummary;
    /**
     * @var TransactionDetails
     */
    private $transactionDetails;
    /**
     * @var Accounts
     */
    private $accounts;
    /**
     * @var AccountSummary
     */
    private $accountSummary;
    /**
     * @var AccountDetails
     */
    private $accountDetails;
    /**
     * @var GlTransactionSummary
     */
    private $glSummary;
    /**
     * @var GlTransactionDetails
     */
    private $glDetails;


    private $controlno;

    function __construct()
    {
        $this->transactionSummary   = new TransactionSummary();
        $this->transactionDetails   = new TransactionDetails();
        $this->accounts             = new Accounts();
        $this->accountSummary       = new AccountSummary();
        $this->accountDetails       = new AccountDetails();
        $this->glSummary            = new GlTransactionSummary();
        $this->glDetails            = new GlTransactionDetails();

        $this->controlno            = 0;
    }

    /**
     * Post Transaction
     *
     * @param $data
     * @return mixed
     */
    public function postTransaction($data)
    {
        DB::beginTransaction();

        try {

            $data       = json_decode(json_encode($data));

            $this->controlno      = $this->transactionSummary->where('subscription',$data->subscription)->max('controlno') + 1;

            $this->transactionSummary->create([
                'subscription'          => $data->subscription,
                'controlno'             => $this->controlno,
                'transactionrefno'      => $data->refno,
                'module'                => $data->module,
                'user'                  => $data->user,
                'status'                => $data->status,
                'posted_by'             => $data->posted_by,
                'explanation'           => $data->explanation,
                'posted_at'             => $data->posted_at
            ]);

            for($i=0;$i<count($data->details->client);$i++)
            {
                // reversal only
                $transamount                = $data->status==4 ? $data->details->transamount[$i] > 0 ? $data->details->transamount[$i] * -1 : $data->details->transamount[$i] * 1 : $data->details->transamount[$i];

                $this->transactionDetails->create([
                    'subscription'          => $data->subscription,
                    'controlno'             => $this->controlno,
                    'glaccount'             => $data->details->glaccount[$i],
                    'client'                => $data->details->client[$i],
                    'transactionrefno'      => $data->refno,
                    'accountclass'          => $data->details->accountclass[$i],
                    'accounttype'           => $data->details->accounttype[$i],
                    'accountentry'          => $data->details->accountentry[$i],
                    'transamount'           => $transamount,
                    'transamountdue'        => $transamount,
                    'paymentform'           => $data->details->paymentform[$i],
                    'transactiontag'        => $data->details->transactiontag[$i]
                ]);
            }

        } catch (\Exception $e) {

            dd($e->getMessage());

            DB::rollBack();

        }

        DB::commit();

        return $this->controlno;
    }

    /**
     * Post Account Transaction
     * @param $data
     */
    public function postAccountTransaction($data)
    {
        DB::beginTransaction();

        try {

            $data       = json_decode(json_encode($data));

            for($i=0;$i<count($data->details->client);$i++)
            {
                // Check for existing account
                $accountno            = $this->accounts->checkAccount($data->subscription,$data->details->accountclass[$i],$data->details->accounttype[$i],$data->details->client[$i]);

                // Create new account summary
                $this->accountSummary->create([
                    'subscription'      => $data->subscription,
                    'controlno'         => $data->controlno,
                    'client'            => $data->details->client,
                    'accountclass'      => $data->details->accountclass[$i],
                    'accounttype'       => $data->details->accounttype[$i],
                    'accountentry'      => $data->details->accountentry[$i],
                    'accountno'         => $accountno,
                    'user'              => $data->user
                ]);

                // reversal only
                $transamount    = $data->status=="4" ? $data->details->transamount[$i] > 0 ? $data->details->transamount[$i] * -1 : $data->details->transamount[$i] * 1 : $data->details->transamount[$i];

                // Create account details
                $this->accountDetails->create([
                    'subscription'      => $data->subscription,
                    'controlno'         => $data->controlno,
                    'client'            => $data->details->client[$i],
                    'accountclass'      => $data->details->accountclass[$i],
                    'accounttype'       => $data->details->accounttype[$i],
                    'accountentry'      => $data->details->accountentry[$i],
                    'accountno'         => $accountno,
                    'amount'            => $transamount
                ]);

            }


        } catch (\Exception $e) {

            DB::rollBack();

        }

        DB::commit();
    }

    /**
     * Post GL Transaction
     * @param $data
     */
    public function postGlTransaction($data)
    {
        DB::beginTransaction();

        try {

            $data       = json_decode(json_encode($data));

            for($i=0;$i<count($data->details->client);$i++)
            {
                $transamount    = $data->status=="4" ? $data->details->transamount[$i] > 0 ? $data->details->transamount[$i] * -1 : $data->details->transamount[$i] * 1 : $data->details->transamount[$i];

                $this->glDetails->create([
                    'subscription'      => $data->subscription,
                    'controlno'         => $data->controlno,
                    'accountclass'      => $data->details->accountclass[$i],
                    'accounttype'       => $data->details->accounttype[$i],
                    'accountentry'      => $data->details->accountentry[$i],
                    'client'            => $data->details->client[$i],
                    'glaccount'         => $data->details->glaccount[$i],
                    'glamount'          => $transamount
                ]);
            }


        } catch (\Exception $e) {

            DB::rollBack();

        }

        DB::commit();
    }

}