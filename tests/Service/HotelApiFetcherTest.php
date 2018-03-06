<?php

namespace App\Tests\Service;

use App\Model\Hotel;
use App\Service\AbstractHotelFetcher;
use App\Service\AbstractRestClient;
use App\Service\HotelApiFetcher;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HotelApiFetcherTest extends KernelTestCase
{
    /** @var AbstractHotelFetcher */
    protected $hotelApiFetcher;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $jsonDeserializer = $kernel->getContainer()->get('app.service.json_deserializer');

        $restClient = $this->getMockBuilder(AbstractRestClient::class)
            ->getMockForAbstractClass();

        $restClient->expects($this->any())->method('getResponseBody')->willReturn(
            <<<EOF
{
   "hotels":[
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
      },
      {
         "name":"Rotana Hotel",
         "price":80.6,
         "city":"cairo",
         "availability":[
            {
               "from":"10-10-2020",
               "to":"12-10-2020"
            },
            {
               "from":"25-10-2020",
               "to":"10-11-2020"
            },
            {
               "from":"05-12-2020",
               "to":"18-12-2020"
            }
         ]
      },
      {
         "name":"Le Meridien",
         "price":89.6,
         "city":"london",
         "availability":[
            {
               "from":"01-10-2020",
               "to":"12-10-2020"
            },
            {
               "from":"05-10-2020",
               "to":"10-11-2020"
            },
            {
               "from":"05-12-2020",
               "to":"28-12-2020"
            }
         ]
      },
      {
         "name":"Golden Tulip",
         "price":109.6,
         "city":"paris",
         "availability":[
            {
               "from":"04-10-2020",
               "to":"17-10-2020"
            },
            {
               "from":"16-10-2020",
               "to":"11-11-2020"
            },
            {
               "from":"01-12-2020",
               "to":"09-12-2020"
            }
         ]
      },
      {
         "name":"Novotel Hotel",
         "price":111,
         "city":"Vienna",
         "availability":[
            {
               "from":"20-10-2020",
               "to":"28-10-2020"
            },
            {
               "from":"04-11-2020",
               "to":"20-11-2020"
            },
            {
               "from":"08-12-2020",
               "to":"24-12-2020"
            }
         ]
      },
      {
         "name":"Concorde Hotel",
         "price":79.4,
         "city":"Manila",
         "availability":[
            {
               "from":"10-10-2020",
               "to":"19-10-2020"
            },
            {
               "from":"22-10-2020",
               "to":"22-11-2020"
            },
            {
               "from":"03-12-2020",
               "to":"20-12-2020"
            }
         ]
      }
   ]
}
EOF

        );

        $this->hotelApiFetcher = new HotelApiFetcher($restClient,$jsonDeserializer);
    }

    public function testGetHotels()
    {
         $hotels = $this->hotelApiFetcher->getHotels();

         $this->assertCount(6,$hotels,'wrong hotels count');
         foreach ($hotels as $hotel) {
             $this->assertInstanceOf(Hotel::class,$hotel,'result array contains objects not of type hotel');
         }
    }
}
