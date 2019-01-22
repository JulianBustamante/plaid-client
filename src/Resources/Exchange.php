<?php

namespace JulianBustamante\Plaid\Resources;

/**
 * The /exchange endpoint allows developers to Exchange a Link public_token for
 * an API access_token. A public_token becomes invalidated once it has been
 * successfully exchanged for an access_token.
 */
class Exchange extends ResourceAbstract
{
    public function exchange($public_token)
    {
        return $this->handleRequest(function ($client) use ($public_token) {
            return $client->post('/item/public_token/exchange', [
                'json' => [
                        'public_token' => $public_token,
                    ] + $this->plaid->getAPIKeys()
            ]);
        });
    }
}
