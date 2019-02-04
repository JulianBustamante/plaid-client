<?php

namespace JulianBustamante\Plaid\Resources;

use GuzzleHttp\ClientInterface;

/**
 * The balance endpoint returns the real-time balance of a user's accounts. It
 * may be used for existing users that were added via any of Plaid's products.
 * The Current Balance is the total amount of funds in the account.
 * The Available Balance is the Current Balance less any outstanding hold or
 * debits that have not yet posted to the account. Note that not all
 * institutions calculate the Available Balance. In the case that Available
 * Balance is unavailable from the institution, Plaid will either return an
 * Available Balance value of null or only return a Current Balance.
 *
 * https://plaid.com/docs/api/#balance
 */
class Balance extends ResourceAbstract
{
    public function balance($access_token, array $account_ids = [])
    {
        return $this->handleRequest(function (ClientInterface $client) use ($access_token, $account_ids) {
            $data = $this->getBaseDataWithAccounts($access_token, $account_ids);

            return $client->post('/accounts/balance/get', $data);
        });
    }
}
