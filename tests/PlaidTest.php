<?php

namespace JulianBustamante\Plaid\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use JulianBustamante\Plaid\Exceptions\InvalidAccessTokenException;
use JulianBustamante\Plaid\Exceptions\InvalidPublicTokenException;
use JulianBustamante\Plaid\Exceptions\InvalidEnvironmentException;
use JulianBustamante\Plaid\Plaid;

/**
 * Class TestCase
 *
 * @author  Julián Bustamante
 */
class PlaidTest extends TestCase
{

    public function testClientInstance(): void
    {
        $this->assertInstanceOf(Plaid::class, $this->plaid);
    }

    public function testInvalidEnvironment(): void
    {
        $this->expectException(InvalidEnvironmentException::class);

        $plaid = new Plaid(
            '5b63374d5c103e0011edb4ae',
            'ccc651ba3c17890150dbc67a76f3d8',
            'e9ee53553d5f06ea78fbf415c41ef7',
            'invalid'
        );
    }

    public function testNotAvailableMethod(): void
    {
        $this->expectException(\BadMethodCallException::class);

        $this->plaid->notAvailableMethod();
    }

    public function testInvalidPublicToken(): void
    {
        $mock = new MockHandler([new Response(400, [], $this->getInvalidPublicTokenBody())]);
        $this->injectMockedClient($mock);

        $this->expectException(InvalidPublicTokenException::class);

        $this->plaid->exchange('public-sandbox-6425b635-9f06-45b1-94ac-4a40746c8d31');
    }

    public function testInvalidAccessToken(): void
    {
        $mock = new MockHandler([new Response(400, [], $this->getInvalidAccessTokenBody())]);
        $this->injectMockedClient($mock);

        $this->expectException(InvalidAccessTokenException::class);

        $this->plaid->auth('public-sandbox-6425b635-9f06-45b1-94ac-4a40746c8d31');
    }

    public function testAuth(): void
    {
        $mock = new MockHandler([new Response(200, [], $this->getAuthBody())]);
        $this->injectMockedClient($mock);

        $response = $this->plaid->auth('access-sandbox-d8e27226-14a4-43cf-9009-2e7f602fd557');
        $actual = $response->getBody()->getContents();
        $this->assertJsonStringEqualsJsonString($this->getAuthBody(), $actual);
    }

    public function testExchange(): void
    {
        $mock = new MockHandler([new Response(200, [], $this->getExchangeBody())]);
        $this->injectMockedClient($mock);

        $response = $this->plaid->exchange('public-sandbox-1d66dfa8-7a2c-417a-a3e6-a6bcf4770ea7');
        $actual = $response->getBody()->getContents();
        $this->assertJsonStringEqualsJsonString($this->getExchangeBody(), $actual);
    }

    public function testBalance(): void
    {
        $mock = new MockHandler([new Response(200, [], $this->getBalanceBody())]);
        $this->injectMockedClient($mock);

        $response = $this->plaid->balance('access-sandbox-d8e27226-14a4-43cf-9009-2e7f602fd557');
        $actual = $response->getBody()->getContents();
        $this->assertJsonStringEqualsJsonString($this->getBalanceBody(), $actual);
    }
}
