<?php

namespace JulianBustamante\Plaid\Resources;

use GuzzleHttp\ClientInterface;

/**
 * The /auth/get endpoint allows you to collect a user's bank account and
 * routing number, along with basic account data and balances. The product
 * performs two crucial functions—it translates bank access credentials
 * (username & password) into an accurate account and routing number. No input
 * of account or routing number is necessary. Secondly it validates that this
 * is the owner of this account number, in a NACHA compliant manner. No need for
 * micro-deposits or any other secondary authentication.
 *
 * https://plaid.com/docs/api/#auth
 */
class Auth extends ResourceAbstract
{
    public function auth($access_token, $account_ids = [])
    {
        return $this->handleRequest(function (ClientInterface $client) use ($access_token, $account_ids) {
            $data = [
                'json' => [
                    'access_token' => $access_token,
                ] + $this->plaid->getAPIKeys(),
            ];

            if ($account_ids) {
                $data['json']['options']['account_ids'] = $account_ids;
            }

            return $client->post('/auth/get', $data);
        });
    }
}
