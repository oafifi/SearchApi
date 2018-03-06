<?php

namespace App\Service;

/**
 * Interface AbstractStringDeserializer
 * @package App\Service
 *
 * Interface for string deserialization, can be made more generic to support many formats but for the sake of simplicity
 * now sub classes implementations will determine the supported string format.
 */
Interface StringDeserializerInterface
{
    /**
     * @param string $string
     * @param string $type
     * @return mixed
     */
    public function deserializeString(string $string, string $type);
}