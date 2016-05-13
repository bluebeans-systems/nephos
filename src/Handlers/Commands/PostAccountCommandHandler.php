<?php

namespace BluebeansSystems\Nephos\Handlers\Commands;

use BluebeansSystems\Nephos\Commands\PostAccountCommand;
use BluebeansSystems\Nephos\Models\AccountDetails;
use BluebeansSystems\Nephos\Models\Accounts;
use BluebeansSystems\Nephos\Models\AccountSummary;
use Illuminate\Database\DatabaseManager as DB;

class PostAccountCommandHandler
{
    /**
     * @var DB
     */
    private $db;
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
     * Create the command handler.
     *
     * @param DB $db
     * @param Accounts $accounts
     * @param AccountSummary $accountSummary
     * @param AccountDetails $accountDetails
     */
    public function __construct(DB $db, Accounts $accounts, AccountSummary $accountSummary, AccountDetails $accountDetails)
    {
        $this->db = $db;
        $this->accounts = $accounts;
        $this->accountSummary = $accountSummary;
        $this->accountDetails = $accountDetails;

    }

    /**
     * Handle the command.
     *
     * @param  PostAccountCommand $command
     * @throws \Exception
     */
    public function handle(PostAccountCommand $command)
    {
        $this->db->beginTransaction();

        try {

            for($i=0;$i<count($command->client);$i++)
            {
                // Check for existing account
                $accountno            = $this->accounts->checkAccount($command->subscription[0],$command->accountclass[$i],$command->accounttype[$i],$command->client[$i]);


                // Create new account summary
                $this->accountSummary->create([
                                                'subscription'      => $command->subscription[0],
                                                'controlno'         => $command->controlno[0],
                                                'client'            => $command->client[$i],
                                                'accountclass'      => $command->accountclass[$i],
                                                'accounttype'       => $command->accounttype[$i],
                                                'accountentry'      => $command->accountentry[$i],
                                                'accountno'         => $accountno,
                                                'user'              => $command->user[0]
                                            ]);

                // reversal only
                $transamount    = $command->status[0]=="4" ? $command->transamount[$i] > 0 ? $command->transamount[$i] * -1 : $command->transamount[$i] * 1 : $command->transamount[$i];

                // Create account details
                $this->accountDetails->create([
                                                'subscription'      => $command->subscription[0],
                                                'controlno'         => $command->controlno[0],
                                                'client'            => $command->client[$i],
                                                'accountclass'      => $command->accountclass[$i],
                                                'accounttype'       => $command->accounttype[$i],
                                                'accountentry'      => $command->accountentry[$i],
                                                'accountno'         => $accountno,
                                                'amount'            => $transamount
                                            ]);

            }


        } catch (\Exception $e) {

            $this->db->rollBack();

        }

        $this->db->commit();
    }
}
