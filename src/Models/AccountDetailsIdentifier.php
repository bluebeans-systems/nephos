<?php

namespace BluebeansSystems\Nephos\Models;

class AccountDetailsIdentifier
{
    protected $properties;

    public $seqno;

    public $client;

    public $glaccount;

    public $transactionrefno;

    public $module;

    public $transtype;

    public $accountclass;

    public $accounttype;

    public $accountentry;

    public $transamount;

    public $transamountdue;

    public $paymentform;

    public $transactiontag;

    /**
     * @return mixed
     */
    public function getGlaccount()
    {
        return $this->glaccount;
    }

    /**
     * @param mixed $glaccount
     */
    public function setGlaccount($glaccount)
    {
        $this->glaccount[] = $glaccount;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client[] = $client;
    }

    /**
     * @return mixed
     */
    public function getAccountclass()
    {
        return $this->accountclass;
    }

    /**
     * @param mixed $accountclass
     */
    public function setAccountclass($accountclass)
    {
        $this->accountclass[] = $accountclass;
    }

    /**
     * @return mixed
     */
    public function getAccounttype()
    {
        return $this->accounttype;
    }

    /**
     * @param mixed $accounttype
     */
    public function setAccounttype($accounttype)
    {
        $this->accounttype[] = $accounttype;
    }

    /**
     * @return mixed
     */
    public function getAccountentry()
    {
        return $this->accountentry;
    }

    /**
     * @param mixed $accountentry
     */
    public function setAccountentry($accountentry)
    {
        $this->accountentry[] = $accountentry;
    }

    /**
     * @return mixed
     */
    public function getTransamount()
    {
        return $this->transamount;
    }

    /**
     * @param mixed $transamount
     */
    public function setTransamount($transamount)
    {
        $this->transamount[] = $transamount;
    }

    /**
     * @return mixed
     */
    public function getTransamountdue()
    {
        return $this->transamountdue;
    }

    /**
     * @param mixed $transamountdue
     */
    public function setTransamountdue($transamountdue)
    {
        $this->transamountdue[] = $transamountdue;
    }

    /**
     * @return mixed
     */
    public function getPaymentform()
    {
        return $this->paymentform;
    }

    /**
     * @param mixed $paymentform
     */
    public function setPaymentform($paymentform)
    {
        $this->paymentform[] = $paymentform;
    }

    /**
     * @return mixed
     */
    public function getTransactiontag()
    {
        return $this->transactiontag;
    }

    /**
     * @param mixed $transactiontag
     */
    public function setTransactiontag($transactiontag)
    {
        $this->transactiontag = $transactiontag;
    }

    /**
     * @return mixed
     */
    public function getTransactionrefno()
    {
        return $this->transactionrefno;
    }

    /**
     * @param mixed $transactionrefno
     */
    public function setTransactionrefno($transactionrefno)
    {
        $this->transactionrefno[] = $transactionrefno;
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     */
    public function setModule($module)
    {
        $this->module[] = $module;
    }

    /**
     * @return mixed
     */
    public function getTranstype()
    {
        return $this->transtype;
    }

    /**
     * @param mixed $transtype
     */
    public function setTranstype($transtype)
    {
        $this->transtype[] = $transtype;
    }

    /**
     * @return mixed
     */
    public function getSeqno()
    {
        return $this->seqno;
    }

    /**
     * @param mixed $seqno
     */
    public function setSeqno($seqno)
    {
        $this->seqno[] = $seqno;
    }
}
