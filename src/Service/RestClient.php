<?php

namespace App\Service;

/**
 * Class RestClient
 * @package App\Service
 *
 * This class represents a rest client implementation using basic file_get_contents()
 * A simple getResponseBody method is added for the sake of simplicity, in real world projects other methods should be added
 * that handle all types of requests and return a unified Request object with all needed info
 *
 */
class RestClient extends AbstractRestClient
{
    public function getResponseBody(string $url): string
    {
        return file_get_contents($url);
    }
}