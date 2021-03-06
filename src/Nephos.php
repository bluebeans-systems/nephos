<?php

namespace BluebeansSystems\Nephos;

use App\FrontOfficeTransaction;
use App\ProductTransaction;
use BluebeansSystems\Nephos\Models\AccountDetails;
use BluebeansSystems\Nephos\Models\AccountDetailsIdentifier;
use BluebeansSystems\Nephos\Models\AccountIdentifier;
use BluebeansSystems\Nephos\Models\Accounts;
use BluebeansSystems\Nephos\Models\AccountSummary;
use BluebeansSystems\Nephos\Models\GlAccounts;
use BluebeansSystems\Nephos\Models\TransactionDetails;
use BluebeansSystems\Nephos\Models\TransactionSummary;
use BluebeansSystems\Nephos\Models\GlTransactionDetails;
use BluebeansSystems\Nephos\Models\GlTransactionSummary;
use BluebeansSystems\Nephos\Models\TransactionTags;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

    private $accountIdentifier;

    private $accountDetailsIdentifier;

    private $carbon;

    private $controlno;

    function __construct()
    {
        $this->transactionSummary           = new TransactionSummary();
        $this->transactionDetails           = new TransactionDetails();
        $this->accounts                     = new Accounts();
        $this->accountSummary               = new AccountSummary();
        $this->accountDetails               = new AccountDetails();
        $this->glSummary                    = new GlTransactionSummary();
        $this->glDetails                    = new GlTransactionDetails();
        $this->glAccounts                   = new GlAccounts();

        $this->accountIdentifier            = new AccountIdentifier();
        $this->accountDetailsIdentifier     = new AccountDetailsIdentifier();
        $this->carbon                       = new Carbon();

        $this->controlno                    = 0;
    }

    /**
     * Save Transaction
     *
     *  Returns Transaction Summary Control No.
     *
     * @param $data
     * @return int
     */
    public function saveTransaction($data)
    {
        DB::beginTransaction();

        try {

            $data       = json_decode(json_encode($data));

            $this->controlno      = $this->transactionSummary->where('subscription',$data->subscription)->max('controlno') + 1;

            $this->transactionSummary->create([
                'subscription'          => $data->subscription,
                'controlno'             => $this->controlno,
                'transactionrefno'      => $data->transactionrefno,
                'module'                => $data->module,
                'transtype'             => $data->transtype,
                'client'                => $data->client,
                'docno'                 => $data->docno,
                'batchno'               => $data->batchno,
                'user'                  => $data->user,
                'status'                => $data->status,
                'posted_by'             => $data->posted_by,
                'explanation'           => $data->explanation,
                'transaction_at'        => $data->transaction_at,
                'posted_at'             => $data->posted_at,
                'is_fo'                 => $data->is_fo
            ]);

            $this->saveTransactionDetails($this->controlno, $data);

        } catch (\Exception $e) {

            DB::rollBack();

            dd($e->getMessage());

        }

        DB::commit();

        return $this->controlno;
    }

    /**
     * Save Transaction Details
     *
     * @param $controlno
     * @param $data
     */
    public function saveTransactionDetails($controlno, $data)
    {
        DB::beginTransaction();

        try {

            for($i=0;$i<count($data->details->client);$i++)
            {
                $transamount                = $data->details->transamount[$i];

                $this->transactionDetails->create([
                    'subscription'          => $data->subscription,
                    'controlno'             => $controlno,
                    'glaccount'             => $data->details->glaccount[$i],
                    'client'                => $data->details->client[$i],
                    'seqno'                 => $data->details->seqno[$i],
                    'transactionrefno'      => $data->transactionrefno,
                    'module'                => $data->module,
                    'transtype'             => $data->transtype,
                    'accountclass'          => $data->details->accountclass[$i],
                    'accounttype'           => $data->details->accounttype[$i],
                    'accountentry'          => $data->details->accountentry[$i],
                    'transamount'           => $transamount,
                    'transamountdue'        => $transamount,
                    'paymentform'           => $data->details->paymentform[$i],
                    'transactiontag'        => $data->details->transactiontag
                ]);
            }

        } catch (\Exception $e) {

            DB::rollBack();

            dd($e->getMessage());
        }

        DB::commit();
    }

    /**
     * Save Front Office Transaction
     *
     * @param $controlno
     * @param Request $request
     */
    public function saveFrontOfficeTransaction($controlno, Request $request)
    {
        $fo                     = new FrontOfficeTransaction();

        $receiptno              = $fo->max('receiptno') + 1;

        $fo->controlno          = $controlno;
        $fo->client             = 1;
        $fo->transactionrefno   = $controlno;
        $fo->transactiontype    = 30; // POS
        $fo->receiptno          = $receiptno;
        $fo->user               = $request->user()->id;
        $fo->save();
    }

    /**
     * Save Product Transaction
     *
     * @param $controlno
     * @param Request $request
     */
    public function saveProductTransaction($controlno, Request $request)
    {
        foreach($request->get('products') as $val)
        {
            ProductTransaction::create([
                'controlno'             => $controlno,
                'transactionrefno'      => $controlno,
                'transactiontype'       => 30, // POS
                'entrytype'             => 9,  // POS Receipt
                'product'               => $val["Key"],
                'pricetype'             => 1, // Retail Price
                'quantity'              => $val["Value"]["Key"],
                'amount'                => $val["Value"]["Value"],
                'remarks'               => "",
                'user'                  => $request->user()->id
            ]);

        }
    }

    /**
     * Post Transaction
     * @param TransactionSummary $transactionSummary
     * @internal param $data
     */
    public function postTransaction(TransactionSummary $transactionSummary)
    {
        DB::beginTransaction();

        try {

            $transactionSummary->update(['status'   => 2]);

        } catch (\Exception $e) {

            DB::rollBack();

            dd($e->getMessage());

        }

        DB::commit();
    }

    /**
     * Update Transaction
     *
     * @param $data
     */
    public function updateTransaction($data, $controlno)
    {
        DB::beginTransaction();

        try {

            $summary    = $this->transactionSummary->where('controlno',$controlno);

            $summary->update([
                'client'                => $data->client,
                'docno'                 => $data->docno,
                'batchno'               => $data->batchno,
                'user'                  => $data->user,
                'status'                => $data->status,
                'posted_by'             => $data->posted_by,
                'explanation'           => $data->explanation,
                'transaction_at'        => $data->transaction_at,
                'posted_at'             => $data->posted_at,
            ]);

            // Remove & Store Transaction Details
            $summary->first()->details()->delete();

            $this->saveTransactionDetails($controlno, $data);

        } catch (\Exception $e) {

            DB::rollBack();

            dd($e->getMessage());

        }

        DB::commit();
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
                $accountno            = $this->accounts->checkAccount($data->subscription,$data->refno,$data->details->accountclass[$i],$data->details->accounttype[$i],$data->details->client[$i]);

                // Create new account summary
                $this->accountSummary->create([
                    'subscription'      => $data->subscription,
                    'controlno'         => $data->controlno,
                    'client'            => $data->details->client,
                    'accountclass'      => $data->details->accountclass[$i],
                    'accounttype'       => $data->details->accounttype[$i],
                    'accountentry'      => $data->details->accountentry[$i],
                    'accountno'         => $accountno,
                    'transactionrefno'  => $data->refno,
                    'user'              => $data->user
                ]);

                // Create account details
                $this->accountDetails->create([
                    'subscription'      => $data->subscription,
                    'controlno'         => $data->controlno,
                    'client'            => $data->details->client[$i],
                    'accountclass'      => $data->details->accountclass[$i],
                    'accounttype'       => $data->details->accounttype[$i],
                    'accountentry'      => $data->details->accountentry[$i],
                    'accountno'         => $accountno,
                    'transactionrefno'  => $data->refno,
                    'amount'            => $data->details->transamount[$i]
                ]);

            }


        } catch (\Exception $e) {

            DB::rollBack();

        }

        DB::commit();
    }

    /**
     * Post GL Transaction
     *
     * @param $data
     */
    public function postGlTransaction($data)
    {
        DB::beginTransaction();

        try {

            $data       = json_decode(json_encode($data));

            for($i=0;$i<count($data->details->client);$i++)
            {
                $this->glDetails->create([
                    'subscription'      => $data->subscription,
                    'controlno'         => $data->controlno,
                    'accountclass'      => $data->details->accountclass[$i],
                    'accounttype'       => $data->details->accounttype[$i],
                    'accountentry'      => $data->details->accountentry[$i],
                    'client'            => $data->details->client[$i],
                    'glaccount'         => $data->details->glaccount[$i],
                    'glamount'          => $data->details->transamount[$i]
                ]);
            }


        } catch (\Exception $e) {

            DB::rollBack();

        }

        DB::commit();
    }


    /**
     * Transactions Account Identifier
     *
     * @param Request $request
     * @param array $attributes
     * @param $subscription
     * @return AccountIdentifier
     */
    public function accountIdentifier(Request $request, array $attributes = [], $subscription)
    {
        $user           = $attributes['user'];
        $module         = $attributes['module'];
        $refno          = $attributes['refno'];
        $transtype      = $attributes['transtype'];
        $client         = $attributes['client'];
        $posted_at      = $attributes['posted_at'];
        $is_fo          = $attributes['is_fo'];

        $docno          = $request->get('docno');
        $batchno        = $request->get('batchno');
        $tag            = $request->get('tag');
        $glaccounts     = $request->get('gl_account');
        $explanation    = $request->get('explanation');
        $transaction_at = $this->carbon->parse($request->get('transaction_at'))->format('Y-m-d');

        try {

            $this->accountIdentifier->setSubscription($subscription);
            $this->accountIdentifier->setTransactionrefno($refno);
            $this->accountIdentifier->setModule($module);
            $this->accountIdentifier->setTranstype($transtype);
            $this->accountIdentifier->setClient($client);
            $this->accountIdentifier->setDocno($docno);
            $this->accountIdentifier->setBatchno($batchno);
            $this->accountIdentifier->setUser($user);
            $this->accountIdentifier->setStatus($tag);
            $this->accountIdentifier->setPostedBy($user);
            $this->accountIdentifier->setExplanation($explanation);
            $this->accountIdentifier->setTransactionAt($transaction_at);
            $this->accountIdentifier->setPostedAt($posted_at);
            $this->accountIdentifier->setIsFo($is_fo);

            for($i=0;$i<count($glaccounts);$i++) {

                $amount         = 0;

                if($request->has('debit') && $request->get('debit')[$i] > 0) {
                    $amount     = (float) $request->get('debit')[$i];
                }

                if($request->has('credit') && $request->get('credit')[$i] > 0) {
                    $amount     = (float) ($request->get('credit')[$i] * -1);
                }

                if($amount != 0) {
                    $this->accountDetailsIdentifier->setGlaccount($glaccounts[$i]);
                    $this->accountDetailsIdentifier->setClient($request->get('client')[$i]);
                    $this->accountDetailsIdentifier->setSeqno($i);
                    $this->accountDetailsIdentifier->setTransactionrefno($refno);
                    $this->accountDetailsIdentifier->setModule($module);
                    $this->accountDetailsIdentifier->setTranstype($transtype);
                    $this->accountDetailsIdentifier->setAccountclass($request->get('accountclass')[$i]);
                    $this->accountDetailsIdentifier->setAccounttype($request->get('accounttype')[$i]);
                    $this->accountDetailsIdentifier->setAccountentry($request->get('accountentry')[$i]);
                    $this->accountDetailsIdentifier->setTransamount($amount);
                    $this->accountDetailsIdentifier->setTransamountdue($amount);
                    $this->accountDetailsIdentifier->setPaymentform($request->get('paymentform')[$i]);
                    $this->accountDetailsIdentifier->setTransactiontag($tag);
                }
            }

            $this->accountIdentifier->setDetails($this->accountDetailsIdentifier);

        } catch (\Exception $e) {

            dd('Error Account Identifier: '.$e->getMessage());

        }

        return $this->accountIdentifier;
    }

    /**
     * Get Specific Transaction
     *
     * @param $controlno
     * @return null
     */
    public function transaction($controlno)
    {
        $transaction   = null;

        try {

            $transaction        = TransactionSummary::where('controlno',$controlno)->firstOrFail();

        } catch (\Exception $e) {

            dd('Error: '.$e->getMessage());

        }

        return $transaction;
    }

    /**
     * Generate Transaction Summary
     *
     * @param $start_date
     * @param $end_date
     * @return null
     */
    public function transactions($start_date, $end_date)
    {
        $transactions   = null;

        try {

            $transactions   = TransactionSummary::whereBetween('created_at',[$this->carbon->parse($start_date), $this->carbon->parse($end_date)->hour(11)->minute(59)->second(59)])
                                                ->orderBy('controlno')
                                                ->orderBy('created_at','DESC')
                                                ->get();

        } catch (\Exception $e) {

            dd($e->getMessage());

        }

        return $transactions;
    }

    /**
     * Generate Transaction Details
     *
     * @param $start_date
     * @param $end_date
     * @return null
     */
    public function transactionDetails($start_date, $end_date)
    {
        $transactions   = null;

        try {

            $transactions   = TransactionDetails::selectRaw('*,SUM(transamount) as total')
                                ->whereHas('transactionSummary', function($query) use ($start_date, $end_date) {
                                    if(is_null($start_date)) {
                                        $start_date     = "1990-01-01";
                                    }

                                    $query->whereBetween('posted_at',[$this->carbon->parse($start_date),$this->carbon->parse($end_date)->hour(11)->minute(59)->second(59)])
                                          ->where('status',2);
                                })
                                    ->groupBy('glaccount')
                                    ->get();

        } catch (\Exception $e) {

            dd($e->getMessage());

        }

        return $transactions;
    }

    /**
     * Generate Asset Accounts Array
     *
     */
    public function getAssetAccounts()
    {
        $accounts   = [];

        foreach($this->glAccounts->all() as $glaccount) {
            if($glaccount->isAsset() && $glaccount->isDetail()) {
                $accounts[$glaccount->getGlAccountType->description][$glaccount->glaccount]  = $glaccount->description;
            }
        }

        return $accounts;
    }

    /**
     * Generate Liability Accounts Array
     *
     */
    public function getLiabilityAccounts()
    {
        $accounts   = [];

        foreach($this->glAccounts->all() as $glaccount) {
            if($glaccount->isLiability() && $glaccount->isDetail()) {
                $accounts[$glaccount->getGlAccountType->description][$glaccount->glaccount]  = $glaccount->description;
            }
        }

        return $accounts;
    }

    /**
     * Generate Revenue Accounts Array
     *
     */
    public function getRevenueAccounts()
    {
        $accounts   = [];

        foreach($this->glAccounts->all() as $glaccount) {
            if($glaccount->isRevenue() && $glaccount->isDetail()) {
                $accounts[$glaccount->getGlAccountType->description][$glaccount->glaccount]  = $glaccount->description;
            }
        }

        return $accounts;
    }

    /**
     * Generate Expense Accounts Array
     *
     */
    public function getExpenseAccounts()
    {
        $accounts   = [];

        foreach($this->glAccounts->all() as $glaccount) {
            if($glaccount->isExpense() && $glaccount->isDetail()) {
                $accounts[$glaccount->getGlAccountType->description][$glaccount->glaccount]  = $glaccount->description;
            }
        }

        return $accounts;
    }

    /**
     * Generate Equity Accounts Array
     *
     */
    public function getEquityAccounts()
    {
        $accounts   = [];

        foreach($this->glAccounts->all() as $glaccount) {
            if($glaccount->isExpense() && $glaccount->isDetail()) {
                $accounts[$glaccount->getGlAccountType->description][$glaccount->glaccount]  = $glaccount->description;
            }
        }

        return $accounts;
    }

    /**
     * Get Transaction Tags collection
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getTransactionTags()
    {
        return TransactionTags::all()->pluck('tag','name');
    }

}