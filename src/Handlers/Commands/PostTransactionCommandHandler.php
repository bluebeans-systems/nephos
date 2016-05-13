<?php

namespace BluebeansSystems\Nephos\Handlers\Commands;

use BluebeansSystems\Nephos\Commands\PostTransactionCommand;
use BluebeansSystems\Nephos\Models\TransactionDetails;
use BluebeansSystems\Nephos\Models\TransactionSummary;
use Illuminate\Database\DatabaseManager as DB;

class PostTransactionCommandHandler
{
    /**
     * @var TransactionSummary
     */
    private $transactionSummary;
    /**
     * @var TransactionDetails
     */
    private $transactionDetails;

    private $controlno;

    /**
     * Create the command handler.
     *
     * @param DB $db
     * @param TransactionSummary $transactionSummary
     * @param TransactionDetails $transactionDetails
     * @internal param Auth $auth
     */
    public function __construct(DB $db, TransactionSummary $transactionSummary, TransactionDetails $transactionDetails)
    {
        $this->db                   = $db;
        $this->transactionSummary   = $transactionSummary;
        $this->transactionDetails   = $transactionDetails;
        $this->controlno            = 0;
    }

    /**
     * Handle the command.
     *
     * @param  PostTransactionCommand $command
     * @return int
     * @throws \Exception
     */
    public function handle(PostTransactionCommand $command)
    {
        $this->db->beginTransaction();

        try {

            $this->controlno      = $this->transactionSummary->where('subscription',$command->subscription[0])->max('controlno') + 1;

            $this->transactionSummary->create([
                            'subscription'          => $command->subscription[0],
                            'controlno'             => $this->controlno,
                            'transactionrefno'      => $command->transactionrefno[0],
                            'module'                => $command->module[0],
                            'user'                  => $command->user[0],
                            'status'                => $command->status[0],
                            'posted_by'             => $command->posted_by[0],
                            'explanation'           => $command->explanation[0],
                            'posted_at'             => $command->posted_at[0]
            ]);

            for($i=0;$i<count($command->client);$i++)
            {
                // reversal only
                $transamount    = $command->status[0]==4 ? $command->transamount[$i] > 0 ? $command->transamount[$i] * -1 : $command->transamount[$i] * 1 : $command->transamount[$i];

                $this->transactionDetails->create([
                        'subscription'          => $command->subscription[0],
                        'controlno'             => $this->controlno,
                        'glaccount'             => $command->glaccount[$i],
                        'client'                => $command->client[$i],
                        'transactionrefno'      => $command->transactionrefno[0],
                        'accountclass'          => $command->accountclass[$i],
                        'accounttype'           => $command->accounttype[$i],
                        'accountentry'          => $command->accountentry[$i],
                        'transamount'           => $transamount,
                        'transamountdue'        => $transamount,
                        'paymentform'           => $command->paymentform[0],
                        'transactiontag'        => $command->transactiontag[0]
                ]);
            }

        } catch (\Exception $e) {

            $this->db->rollBack();

        }

        $this->db->commit();

        return $this->controlno;
    }
}
