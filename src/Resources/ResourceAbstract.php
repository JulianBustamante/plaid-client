<?php

namespace JulianBustamante\Plaid\Resources;

use GuzzleHttp\Exception\ClientException;
use JulianBustamante\Plaid\Exceptions\InvalidPublicTokenException;
use JulianBustamante\Plaid\Exceptions\InvalidAccessTokenException;
use JulianBustamante\Plaid\Resources\Errors\ErrorAbstract;
use JulianBustamante\Plaid\ServiceAbstract;

abstract class ResourceAbstract
{
    /**
     * Plaid service instance.
     *
     * @var \JulianBustamante\Plaid\ServiceAbstract
     */
    protected $plaid;

    /**
     * @param \JulianBustamante\Plaid\ServiceAbstract $plaid
     */
    public function __construct(ServiceAbstract $plaid)
    {
        $this->plaid  = $plaid;
    }

    /**
     * Handles resources requests.
     *
     * @param \Closure $callback
     *
     * @return mixed
     */
    protected function handleRequest(\Closure $callback)
    {
        try {
            $response = $callback($this->plaid->getClient());
        } catch (ClientException $exception) {
            $this->handleException($exception);
        }

        return \GuzzleHttp\json_decode($response->getBody(), true);
    }

    /**
     * Handles Plaid error codes and throws exceptions.
     *
     * @param \GuzzleHttp\Exception\ClientException $exception
     */
    protected function handleException(ClientException $exception)
    {
        if ($exception->getCode() === 400
            && $exception->hasResponse()
            && $error_code = $this->getErrorCode($exception->getResponse())) {

            switch ($error_code) {
                case ErrorAbstract::INVALID_PUBLIC_TOKEN:
                    throw new InvalidPublicTokenException($exception->getMessage());
                case ErrorAbstract::INVALID_ACCESS_TOKEN:
                    throw new InvalidAccessTokenException($exception->getMessage());
            }
        }

        throw $exception;
    }

    /**
     * @param $response
     *
     * @return bool
     */
    private function getErrorCode($response)
    {
        $body = \GuzzleHttp\json_decode($response->getBody(), true);
        return $body['error_code'] ?? null;
    }
}
