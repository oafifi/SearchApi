<?php

namespace App\Service;

/**
 * Class AbstractRestClient
 * @package App\Service
 *
 * This class represents a base for many implementations of rest clients if needed
 * A simple getResponseBody method is added for the sake of simplicity, in real world projects other methods should be added
 * that return a unified Request object with all needed info
 */
abstract class AbstractRestClient
{

    public abstract function getResponseBody(string $url);
}