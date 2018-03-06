<?php

namespace App\Tests\Service;

use App\Model\Hotel;
use App\Service\JsonDeserializer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class JsonDeserializerTest extends KernelTestCase
{
    /** @var JsonDeserializer */
    protected $jsonDeserializer;

    protected function setUp()
    {
        $kernel = self::bootKernel();
        $this->jsonDeserializer = $kernel->getContainer()->get('app.service.json_deserializer');
    }

    public function testDeserializeString()
    {
        $jsonString = <<<EOF
{
    "name":"Media One Hotel",
    "price":102.2,
    "city":"dubai",
    "availability":[
        {
            "from":"10-10-2020",
            "to":"15-10-2020"
        },
        {
            "from":"25-10-2020",
            "to":"15-11-2020"
        },
        {
            "from":"10-12-2020",
            "to":"15-12-2020"
        }
    ]
}
EOF;
        $deserializedObject = $this->jsonDeserializer->deserializeString($jsonString, Hotel::class);

        $this->assertInstanceOf(Hotel::class, $deserializedObject);
        $this->assertAttributeEquals("Media One Hotel","name", $deserializedObject);
        $this->assertAttributeEquals(102.2,"price", $deserializedObject);
        $this->assertAttributeEquals("dubai","city", $deserializedObject);
        $this->assertAttributeEquals([
            [
                "from" => "10-10-2020",
                "to" => "15-10-2020"
            ],
            [
                "from" => "25-10-2020",
                "to" => "15-11-2020"
            ],
            [
                "from" => "10-12-2020",
                "to" => "15-12-2020"
            ]
        ],
        "availability",
        $deserializedObject
        );

    }
}
