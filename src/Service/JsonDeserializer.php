<?php

namespace App\Service;


use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

class JsonDeserializer implements StringDeserializerInterface
{
    /** @var Serializer */
    private $jmsSerializer;

    public function __construct()
    {
        $this->jmsSerializer = SerializerBuilder::create()->build();
    }

    public function deserializeString(string $string, string $type)
    {
        return $this->jmsSerializer->deserialize($string,$type,'json');
    }
}