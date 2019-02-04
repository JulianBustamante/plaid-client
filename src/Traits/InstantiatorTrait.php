<?php

namespace JulianBustamante\Plaid\Traits;

/**
 * The Instantiator trait which has the magic methods for instantiating Resources
 * @package JulianBustamante\Plaid
 *
 */
trait InstantiatorTrait
{

    /**
     * Generic method to object getter. Since all objects are protected, this
     * method exposes a getter function with the same name as the protected
     * variable, for example
     * $plaid->auth can be referenced by $client->tickets()
     *
     * @param $method
     * @param $arguments
     *
     * @return mixed
     * @throws \Exception
     */
    public function __call($method, $arguments)
    {
        if (array_key_exists($method, $validResources = $this::getValidResources())) {
            $className = $validResources[$method];
            $instance = new $className($this);
        } else {
            throw new \BadMethodCallException("No method called $method available in " . __CLASS__);
        }

        return $instance->$method(...$arguments);
    }
}
