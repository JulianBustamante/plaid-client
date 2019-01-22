<?php

namespace JulianBustamante\Plaid;

use GuzzleHttp\ClientInterface;
use JulianBustamante\Plaid\Exceptions\InvalidEnvironmentException;
use JulianBustamante\Plaid\Traits\InstantiatorTrait;

/**
 * Class ServiceAbstract
 *
 * @package JulianBustamante\Plaid
 */
abstract class ServiceAbstract
{

    use InstantiatorTrait;

    /**
     * Default timeout for API requests.
     */
    public const DEFAULT_TIMEOUT = 600;

    /**
     * Default Plaid API Version.
     */
    public const DEFAULT_API_VERSION = '2018-05-22';

    /**
     * Plaid API environments.
     */
    public const ENV_SANDBOX     = 'sandbox';
    public const ENV_DEVELOPMENT = 'development';
    public const ENV_PRODUCTION  = 'production';
    public const URI_SANDBOX     = 'https://sandbox.plaid.com';
    public const URI_DEVELOPMENT = 'https://development.plaid.com';
    public const URI_PRODUCTION  = 'https://production.plaid.com';

    public const ENVIRONMENTS = [
        self::ENV_SANDBOX     => self::URI_SANDBOX,
        self::ENV_DEVELOPMENT => self::URI_DEVELOPMENT,
        self::ENV_PRODUCTION  => self::URI_PRODUCTION,
    ];

    /**
     * Client used for http requests.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    private $client;

    /**
     * Your Plaid client ID.
     *
     * @var string
     */
    private $client_id;

    /**
     * Your Plaid secret.
     *
     * @var string
     */
    private $secret;

    /**
     * Your Plaid public key.
     *
     * @var string
     */
    private $public_key;

    /**
     * One of sandbox, development, or production.
     *
     * @var string
     */
    private $environment;

    /**
     * Suppress Plaid warnings.
     *
     * @var bool
     */
    private $suppress_warnings;

    /**
     * Timeout for API requests.
     *
     * @var int
     */
    private $timeout;

    /**
     * Plaid API Version.
     *
     * @var string
     */
    private $api_version;

    /**
     * Create a new Plaid Client Instance
     *
     * @param $client_id
     * @param $secret
     * @param $public_key
     * @param $environment
     * @param bool $suppress_warnings
     * @param $timeout
     * @param $api_version
     */
    public function __construct(
        $client_id,
        $secret,
        $public_key,
        $environment,
        $suppress_warnings = false,
        $timeout = self::DEFAULT_TIMEOUT,
        $api_version = self::DEFAULT_API_VERSION
    ) {
        $this->isValidEnvironment($environment);

        $this->client_id   = $client_id;
        $this->secret      = $secret;
        $this->public_key  = $public_key;
        $this->environment = $environment;
        $this->timeout     = $timeout;
        $this->api_version = $api_version;
        $this->suppress_warnings = $suppress_warnings;
    }

    /**
     * Checks if the environment is valid.
     *
     * @param string $environment
     */
    private function isValidEnvironment($environment): void
    {
        if (! array_key_exists($environment, self::ENVIRONMENTS)) {
            throw new InvalidEnvironmentException();
        }
    }

    /**
     * Returns the basic API Keys.
     *
     * @return array
     */
    public function getAPIKeys(): array
    {
        return [
            'client_id' => $this->client_id,
            'secret'    => $this->secret,
        ];
    }

    /**
     * Allows to set a custom client.
     *
     * @param \GuzzleHttp\ClientInterface $client
     */
    public function setClient(ClientInterface $client): void
    {
        $this->client = $client;
    }

    /**
     * Returns the current client.
     *
     * @return \GuzzleHttp\ClientInterface
     */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * Returns the base URI depending on the environment.
     *
     * @return string
     */
    public function getBaseUri(): string
    {
        return self::ENVIRONMENTS[$this->environment];
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    abstract public static function getValidResources(): array;

}
