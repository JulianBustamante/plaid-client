<?php

namespace JulianBustamante\Plaid\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use JulianBustamante\Plaid\Plaid;
use JulianBustamante\Plaid\Resources\Errors\ErrorAbstract;
use PHPUnit\Framework\TestCase as PHPUnit;

class TestCase extends PHPUnit
{
    /**
     * @var \JulianBustamante\Plaid\Plaid
     */
    protected $plaid;

    protected function setUp()
    {
        parent::setUp();

        $this->plaid = new Plaid(
            '5b6a374d5c103a0011fdb4ae',
            'ccb651ba3c17890350dbc67a76a3d8',
            'e9ee53553d5f0eea78fbf415341ef7',
            Plaid::ENV_SANDBOX
        );
    }

    protected function injectMockedClient(MockHandler $mock): void
    {
        $handler = HandlerStack::create($mock);
        // Inject a mocked client to the service.
        $this->plaid->setClient(new Client(['handler' => $handler]));
    }

    protected function getInvalidPublicTokenBody()
    {
        return json_encode([
            'display_message' => null,
            'error_code' => ErrorAbstract::INVALID_PUBLIC_TOKEN,
            'error_message' => 'provided public token is expired. Public tokens expire 30 minutes after creation at which point they can no longer be exchanged',
            'error_type' => 'INVALID_INPUT',
            'request_id' => 'xZbUFtBnVeHOhOG'
        ]);
    }

    protected function getInvalidAccessTokenBody()
    {
        return json_encode([
            'display_message' => null,
            'error_code' => ErrorAbstract::INVALID_ACCESS_TOKEN,
            'error_message' => 'provided token is the wrong type. expected "access", got "public"',
            'error_type' => 'INVALID_INPUT',
            'request_id' => 'xZbUFtBnVeHOhOG'
        ]);
    }

    protected function getExchangeBody()
    {
        return json_encode([
            'access_token' => 'access-sandbox-d8e27226-14a4-43cf-9009-2e7f602fd557',
            'item_id' => 'JenM1wa94PSJqpMBQnGmsB3ArWDJepFdDjNb5',
            'request_id' => 'xZbUFtBnVeHOhOG'
        ]);
    }

    protected function getBalanceBody()
    {
        return json_encode([
            'accounts' => [
                [
                    'account_id' => 'mVmQrMLbgpcWlybX3dgZI5W64ZP97ESLNjXb5',
                    'balances' => [
                        'available' => 100,
                        'current' => 110,
                        'iso_currency_code' => 'USD',
                        'limit' => null,
                        'unofficial_currency_code' => null
                    ],
                    'mask' => '0000',
                    'name' => 'Plaid Checking',
                    'official_name' => 'Plaid Gold Standard 0% Interest Checking',
                    'subtype' => 'checking',
                    'type' => 'depository'
                ],
                [
                    'account_id' => 'yl4GAk35MxCKmQpqMPo7UQKP8wLlRZcymdw9q',
                    'balances' => [
                        'available' => 200,
                        'current' => 210,
                        'iso_currency_code' => 'USD',
                        'limit' => null,
                        'unofficial_currency_code' => null
                    ],
                    'mask' => '1111',
                    'name' => 'Plaid Saving',
                    'official_name' => 'Plaid Silver Standard 0.1% Interest Saving',
                    'subtype' => 'savings',
                    'type' => 'depository'
                ],
                [
                    'account_id' => '9nPqGRVKdpCKJMqwpVBeUwkAQ8KlDjUR18gLL',
                    'balances' => [
                        'available' => null,
                        'current' => 1000,
                        'iso_currency_code' => 'USD',
                        'limit' => null,
                        'unofficial_currency_code' => null
                    ],
                    'mask' => '2222',
                    'name' => 'Plaid CD',
                    'official_name' => 'Plaid Bronze Standard 0.2% Interest CD',
                    'subtype' => 'cd',
                    'type' => 'depository'
                ],
                [
                    'account_id' => 'vVxEpg5AMzcWbV7kZN8yIDWbJQLaXGCWmx1jp',
                    'balances' => [
                        'available' => null,
                        'current' => 410,
                        'iso_currency_code' => 'USD',
                        'limit' => 2000,
                        'unofficial_currency_code' => null
                    ],
                    'mask' => '3333',
                    'name' => 'Plaid Credit Card',
                    'official_name' => 'Plaid Diamond 12.5% APR Interest Credit Card',
                    'subtype' => 'credit card',
                    'type' => 'credit'
                ],
                [
                    'account_id' => 'RgzWRwVoQLUXqRraE3MpIW75MlrJzpfRyjAKq',
                    'balances' => [
                        'available' => 43200,
                        'current' => 43200,
                        'iso_currency_code' => 'USD',
                        'limit' => null,
                        'unofficial_currency_code' => null
                    ],
                    'mask' => '4444',
                    'name' => 'Plaid Money Market',
                    'official_name' => 'Plaid Platinum Standard 1.85% Interest Money Market',
                    'subtype' => 'money market',
                    'type' => 'depository'
                ]
            ],
            'item' => [
                'available_products' => [
                    'assets',
                    'balance',
                    'credit_details',
                    'identity',
                    'income',
                    'transactions'
                ],
                'billed_products' => [
                    'auth'
                ],
                'error' => null,
                'institution_id' => 'ins_3',
                'item_id' => 'JenM1wa94PSJqpMBQnGmsB3ArWDJepFdDjNb5',
                'webhook' => 'https =>//www.genericwebhookurl.com/webhook'
            ],
            'request_id' => 'CVEP92IGTFCCSyS',
        ]);
    }

    protected function getAuthBody()
    {
        return json_encode([
            'accounts' => [
                [
                    'account_id' => 'mVmQrMLbgpcWlybX3dgZI5W64ZP97ESLNjXb5',
                    'balances' => [
                        'available' => 100,
                        'current' => 110,
                        'iso_currency_code' => 'USD',
                        'limit' => null,
                        'unofficial_currency_code' => null
                    ],
                    'mask' => '0000',
                    'name' => 'Plaid Checking',
                    'official_name' => 'Plaid Gold Standard 0% Interest Checking',
                    'subtype' => 'checking',
                    'type' => 'depository'
                ],
                [
                    'account_id' => 'yl4GAk35MxCKmQpqMPo7UQKP8wLlRZcymdw9q',
                    'balances' => [
                        'available' => 200,
                        'current' => 210,
                        'iso_currency_code' => 'USD',
                        'limit' => null,
                        'unofficial_currency_code' => null
                    ],
                    'mask' => '1111',
                    'name' => 'Plaid Saving',
                    'official_name' => 'Plaid Silver Standard 0.1% Interest Saving',
                    'subtype' => 'savings',
                    'type' => 'depository'
                ],
                [
                    'account_id' => '9nPqGRVKdpCKJMqwpVBeUwkAQ8KlDjUR18gLL',
                    'balances' => [
                        'available' => null,
                        'current' => 1000,
                        'iso_currency_code' => 'USD',
                        'limit' => null,
                        'unofficial_currency_code' => null
                    ],
                    'mask' => '2222',
                    'name' => 'Plaid CD',
                    'official_name' => 'Plaid Bronze Standard 0.2% Interest CD',
                    'subtype' => 'cd',
                    'type' => 'depository'
                ],
                [
                    'account_id' => 'vVxEpg5AMzcWbV7kZN8yIDWbJQLaXGCWmx1jp',
                    'balances' => [
                        'available' => null,
                        'current' => 410,
                        'iso_currency_code' => 'USD',
                        'limit' => 2000,
                        'unofficial_currency_code' => null
                    ],
                    'mask' => '3333',
                    'name' => 'Plaid Credit Card',
                    'official_name' => 'Plaid Diamond 12.5% APR Interest Credit Card',
                    'subtype' => 'credit card',
                    'type' => 'credit'
                ],
                [
                    'account_id' => 'RgzWRwVoQLUXqRraE3MpIW75MlrJzpfRyjAKq',
                    'balances' => [
                        'available' => 43200,
                        'current' => 43200,
                        'iso_currency_code' => 'USD',
                        'limit' => null,
                        'unofficial_currency_code' => null
                    ],
                    'mask' => '4444',
                    'name' => 'Plaid Money Market',
                    'official_name' => 'Plaid Platinum Standard 1.85% Interest Money Market',
                    'subtype' => 'money market',
                    'type' => 'depository'
                ]
            ],
            'item' => [
                'available_products' => [
                    'assets',
                    'balance',
                    'credit_details',
                    'identity',
                    'income',
                    'transactions'
                ],
                'billed_products' => [
                    'auth'
                ],
                'error' => null,
                'institution_id' => 'ins_3',
                'item_id' => 'JenM1wa94PSJqpMBQnGmsB3ArWDJepFdDjNb5',
                'webhook' => 'https =>//www.genericwebhookurl.com/webhook'
            ],
            'numbers' => [
                'ach' => [
                    [
                        'account' => '1111222233330000',
                        'account_id' => 'mVmQrMLbgpcWlybX3dgZI5W64ZP97ESLNjXb5',
                        'routing' => '011401533',
                        'wire_routing' => '021000021'
                    ],
                    [
                        'account' => '1111222233331111',
                        'account_id' => 'yl4GAk35MxCKmQpqMPo7UQKP8wLlRZcymdw9q',
                        'routing' => '011401533',
                        'wire_routing' => '021000021'
                    ]
                ],
                'eft' => []
            ],
            'request_id' => 'l2yCP7NsYZhB6na'
        ]);
    }
}
