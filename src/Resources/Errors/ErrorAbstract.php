<?php

namespace JulianBustamante\Plaid\Resources\Errors;

abstract class ErrorAbstract
{

    /**
     * Invalid input errors
     *
     * Returned when all fields are provided and are in the correct format,
     * but the values provided are incorrect in some way.
     */
    public const INVALID_PUBLIC_TOKEN = 'INVALID_PUBLIC_TOKEN';
    public const INVALID_ACCESS_TOKEN = 'INVALID_ACCESS_TOKEN';

    /**
     * API errors
     *
     * Returned during planned maintenance windows and in response to API errors.
     */
    public const PLANNED_MAINTENANCE   = 'PLANNED_MAINTENANCE';
    public const INTERNAL_SERVER_ERROR = 'INTERNAL_SERVER_ERROR';
}
