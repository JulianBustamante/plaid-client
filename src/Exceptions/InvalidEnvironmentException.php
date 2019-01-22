<?php

namespace JulianBustamante\Plaid\Exceptions;

class InvalidEnvironmentException extends PlaidException
{
    protected $message = 'Environment is not valid.';
}
