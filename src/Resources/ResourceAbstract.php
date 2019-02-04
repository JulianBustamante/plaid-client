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
     * Guzzle Response.
     */
    protected $response;

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
     * @return \JulianBustamante\Plaid\Resources\ResourceAbstract
     */
    protected function handleRequest(\Closure $callback): ResourceAbstract
    {
        try {
            $this->response = $callback($this->plaid->getClient());
        } catch (ClientException $exception) {
            $this->handleException($exception);
        }

        return $this;
    }

    /**
     * Handles Plaid error codes and throws exceptions.
     *
     * @param \GuzzleHttp\Exception\ClientException $exception
     */
    protected function handleException(ClientException $exception): void
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
     * Extracts the Plaid error code from the response.
     *
     * @param $response
     *
     * @return bool
     */
    private function getErrorCode($response)
    {
        $body = \GuzzleHttp\json_decode($response->getBody(), true);
        return $body['error_code'] ?? null;
    }

    /**
     * Returns base data required for all the requests.
     *
     * @param $access_token
     * @param $account_ids
     *
     * @return array
     */
    protected function getBaseDataWithAccounts($access_token, array $account_ids): array
    {
        $data = [
            'json' => [
                    'access_token' => $access_token,
                ] + $this->plaid->getAPIKeys(),
        ];

        if (! empty($account_ids)) {
            $data['json']['options']['account_ids'] = $account_ids;
        }

        return $data;
    }

    /**
     * Returns decoded json response.
     *
     * @return mixed
     */
    protected function getData()
    {
        return $this->response !== null ? \GuzzleHttp\json_decode($this->response->getBody(), true) : null;
    }
}
