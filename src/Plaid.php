<?php

namespace JulianBustamante\Plaid;

use JulianBustamante\Plaid\Resources\Auth;
use JulianBustamante\Plaid\Resources\Balance;
use JulianBustamante\Plaid\Resources\Exchange;

/**
 * Class Client
 *
 * PHP Plaid API client.
 * See official documentation at: https://plaid.com/docs.
 *
 * @method \GuzzleHttp\Psr7\Response auth($access_token, array $account_ids = [])
 * @method \GuzzleHttp\Psr7\Response exchange($public_token)
 * @method \GuzzleHttp\Psr7\Response balance($access_token, array $account_ids = [])
 *
 * @package JulianBustamante\Plaid
 */
class Plaid extends ServiceAbstract
{

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public static function getValidResources(): array
    {
        return [
            'auth' => Auth::class,
            'exchange' => Exchange::class,
            'balance' => Balance::class,
            /*'info' => Info::class,
            'risk' => Risk::class,
            'income' => Income::class,
            'balance' => Balance::class,
            'connect' => Connect::class,
            'upgrade' => Upgrade::class,
            'categories' => Categories::class,
            'institutions' => Institutions::class,*/
        ];
    }
}
