<?php

namespace JulianBustamante\Plaid;

use GuzzleHttp\Client;
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
     * One of sandbox, development, or production.
     *
     * @var string
     */
    private $environment;

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
     * @param $environment
     * @param $api_version
     */
    public function __construct(
        $client_id,
        $secret,
        $environment,
        $api_version = null
    ) {
        $this->isValidEnvironment($environment);

        $this->client_id   = $client_id;
        $this->secret      = $secret;
        $this->environment = $environment;
        $this->api_version = $api_version;

        $this->initializeHttpClient();
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

    /**
     * Initializes the Http Client.
     */
    private function initializeHttpClient(): void
    {
        $config = ['base_uri' => $this->getBaseUri()];

        if (null !== $this->api_version) {
            $config += ['headers' => ['Plaid-Version' => $this->api_version]];
        }

        $this->client = new Client($config);
    }
}
