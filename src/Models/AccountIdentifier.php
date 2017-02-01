<?php

namespace App;

class AccountIdentifier
{
    public $subscription;

    public $module;

    public $transactionrefno;

    public $transtype;

    public $controlno;

    public $client;

    public $docno;

    public $batchno;

    public $explanation;

    public $is_fo;

    public $user;

    public $posted_by;

    public $posted_at;

    public $transdate;

    public $status;

    public $details;

    /**
     * @return mixed
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @param mixed $subscription
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;
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
        $this->module = $module;
    }

    /**
     * @return mixed
     */
    public function getControlno()
    {
        return $this->controlno;
    }

    /**
     * @param mixed $controlno
     */
    public function setControlno($controlno)
    {
        $this->controlno = $controlno;
    }

    /**
     * @return mixed
     */
    public function getBatchno()
    {
        return $this->batchno;
    }

    /**
     * @param mixed $batchno
     */
    public function setBatchno($batchno)
    {
        $this->batchno = $batchno;
    }

    /**
     * @return mixed
     */
    public function getExplanation()
    {
        return $this->explanation;
    }

    /**
     * @param mixed $explanation
     */
    public function setExplanation($explanation)
    {
        $this->explanation = $explanation;
    }

    /**
     * @return mixed
     */
    public function getIsFo()
    {
        return $this->is_fo;
    }

    /**
     * @param mixed $is_fo
     */
    public function setIsFo($is_fo)
    {
        $this->is_fo = $is_fo;
    }

    /**
     * @return mixed
     */
    public function getTransdate()
    {
        return $this->transdate;
    }

    /**
     * @param mixed $transdate
     */
    public function setTransdate($transdate)
    {
        $this->transdate = $transdate;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPostedBy()
    {
        return $this->posted_by;
    }

    /**
     * @param mixed $posted_by
     */
    public function setPostedBy($posted_by)
    {
        $this->posted_by = $posted_by;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getPostedAt()
    {
        return $this->posted_at;
    }

    /**
     * @param mixed $posted_at
     */
    public function setPostedAt($posted_at)
    {
        $this->posted_at = $posted_at;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
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
        $this->client = $client;
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
        $this->transtype = $transtype;
    }

    /**
     * @return mixed
     */
    public function getDocno()
    {
        return $this->docno;
    }

    /**
     * @param mixed $docno
     */
    public function setDocno($docno)
    {
        $this->docno = $docno;
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
        $this->transactionrefno = $transactionrefno;
    }
}
