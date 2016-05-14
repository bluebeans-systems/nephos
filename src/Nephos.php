<?php

namespace BluebeansSystems\Nephos;

use BluebeansSystems\Nephos\Models\AccountDetails;
use BluebeansSystems\Nephos\Models\Accounts;
use BluebeansSystems\Nephos\Models\AccountSummary;
use BluebeansSystems\Nephos\Models\TransactionDetails;
use BluebeansSystems\Nephos\Models\TransactionSummary;
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


    private $controlno;

    function __construct()
    {
        $this->transactionSummary   = new TransactionSummary();
        $this->transactionDetails   = new TransactionDetails();
        $this->accounts             = new Accounts();
        $this->accountSummary       = new AccountSummary();
        $this->accountDetails       = new AccountDetails();

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

            $this->controlno      = $this->transactionSummary->where('subscription',$data['subscription'][0])->max('controlno') + 1;

            $this->transactionSummary->create([
                'subscription'          => $data['subscription'][0],
                'controlno'             => $this->controlno,
                'transactionrefno'      => $data['transactionrefno'][0],
                'module'                => $data['module'][0],
                'user'                  => $data['user'][0],
                'status'                => $data['status'][0],
                'posted_by'             => $data['posted_by'][0],
                'explanation'           => $data['explanation'][0],
                'posted_at'             => $data['posted_at'][0]
            ]);

            for($i=0;$i<count($data['client']);$i++)
            {
                // reversal only
                $transamount    = $data['status'][0]==4 ? $data['transamount'][$i] > 0 ? $data['transamount'][$i] * -1 : $data['transamount'][$i] * 1 : $data['transamount'][$i];

                $this->transactionDetails->create([
                    'subscription'          => $data['subscription'][0],
                    'controlno'             => $this->controlno,
                    'glaccount'             => $data['glaccount'][$i],
                    'client'                => $data['client'][$i],
                    'transactionrefno'      => $data['transactionrefno'][0],
                    'accountclass'          => $data['accountclass'][$i],
                    'accounttype'           => $data['accounttype'][$i],
                    'accountentry'          => $data['accountentry'][$i],
                    'transamount'           => $transamount,
                    'transamountdue'        => $transamount,
                    'paymentform'           => $data['paymentform'][0],
                    'transactiontag'        => $data['transactiontag'][0]
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

            for($i=0;$i<count($data['client']);$i++)
            {
                // Check for existing account
                $accountno            = $this->accounts->checkAccount($data['subscription'][0],$data['accountclass'][$i],$data['accounttype'][$i],$data['client'][$i]);

                // Create new account summary
                $this->accountSummary->create([
                    'subscription'      => $data['subscription'][0],
                    'controlno'         => $data['controlno'][0],
                    'client'            => $data['client'][$i],
                    'accountclass'      => $data['accountclass'][$i],
                    'accounttype'       => $data['accounttype'][$i],
                    'accountentry'      => $data['accountentry'][$i],
                    'accountno'         => $accountno,
                    'user'              => $data['user'][0]
                ]);

                // reversal only
                $transamount    = $data['status'][0]=="4" ? $data['transamount'][$i] > 0 ? $data['transamount'][$i] * -1 : $data['transamount'][$i] * 1 : $data['transamount'][$i];

                // Create account details
                $this->accountDetails->create([
                    'subscription'      => $data['subscription'][0],
                    'controlno'         => $data['controlno'][0],
                    'client'            => $data['client'][$i],
                    'accountclass'      => $data['accountclass'][$i],
                    'accounttype'       => $data['accounttype'][$i],
                    'accountentry'      => $data['accountentry'][$i],
                    'accountno'         => $accountno,
                    'amount'            => $transamount
                ]);

            }


        } catch (\Exception $e) {

            DB::rollBack();

        }

        DB::commit();
    }

}