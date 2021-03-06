# plaid-client

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

PHP Client for the plaid.com API

## Install

Via Composer

``` bash
$ composer require JulianBustamante/plaid-client
```

## Usage

``` php
try {
    $plaid = new Plaid($client_id, $secret, $environment);
    $response = $plaid->exchange($public_token);
} catch (PlaidException $e) {
    // Handle
}
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email julian.bustamante@pixelula.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/julianbustamante/plaid-client.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/JulianBustamante/plaid-client/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/julianbustamante/plaid-client.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/julianbustamante/plaid-client.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/julianbustamante/plaid-client.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/julianbustamante/plaid-client
[link-travis]: https://travis-ci.com/JulianBustamante/plaid-client
[link-scrutinizer]: https://scrutinizer-ci.com/g/julianbustamante/plaid-client/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/julianbustamante/plaid-client
[link-downloads]: https://packagist.org/packages/julianbustamante/plaid-client
[link-author]: https://github.com/julianbustamante
[link-contributors]: ../../contributors
