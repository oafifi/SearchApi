<?php

namespace App\Tests\Service;

use App\Model\Hotel;
use App\Service\AbstractHotelFetcher;
use App\Service\HotelSearch;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class HotelSearchTest extends TestCase
{
    /** @var array */
    protected $testHotelsList;
    /** @var HotelSearch */
    protected $hotelSearch;

    protected function setUp()
    {
        $this->testHotelsList = $this->createTestHotelsArray();

        $hotelFetcher = $this->getMockBuilder(AbstractHotelFetcher::class)
            ->getMockForAbstractClass();

        $hotelFetcher->expects($this->any())->method('getHotels')->willReturn($this->testHotelsList);

        $this->hotelSearch = new HotelSearch($hotelFetcher);
    }

    public function testSortByName()
    {
        $this->hotelSearch->sortHotelsBy($this->testHotelsList,'name');

        $this->assertEquals('Le Meridien', $this->testHotelsList[0]->getName());
        $this->assertEquals('Media One Hotel', $this->testHotelsList[1]->getName());
        $this->assertEquals('Rotana Hotel', $this->testHotelsList[2]->getName());
    }

    public function testSortByPrice()
    {
        $this->hotelSearch->sortHotelsBy($this->testHotelsList,'price');

        $this->assertTrue($this->testHotelsList[0]->getPrice() < $this->testHotelsList[1]->getPrice());
        $this->assertTrue($this->testHotelsList[1]->getPrice() < $this->testHotelsList[2]->getPrice());
    }

    public function testSearchByName()
    {
        $result = $this->hotelSearch->searchHotels(['name' => 'Media One Hotel']);

        $this->assertCount(1,$result);
        $this->assertEquals('Media One Hotel', $result[0]->getName());
    }

    public function testSearchByCity()
    {
        $result = $this->hotelSearch->searchHotels(['city' => 'cairo']);

        $this->assertCount(1,$result);
        $this->assertEquals('cairo', $result[0]->getCity());
    }

    public function testSearchByPrice()
    {
        $result = $this->hotelSearch->searchHotels([
            'price_from' => 70.6,
            'price_to' => 82.5
        ]);

        $this->assertCount(1,$result);
        $this->assertTrue($result[0]->getPrice() >= 70.6 && $result[0]->getPrice() <= 82.5);
    }

    public function testSearchByAvailability()
    {
        $result = $this->hotelSearch->searchHotels([
            'date_from' => date_create_from_format('d-m-Y',"11-10-2020"),
            'date_to' => date_create_from_format('d-m-Y',"14-10-2020")
        ]);

        $this->assertCount(2,$result);
    }

    /**
     * @return array
     */
    private function createTestHotelsArray(): array
    {
        $newHotel1 = new Hotel();
        $newHotel1->setName('Media One Hotel');
        $newHotel1->setPrice(102.2);
        $newHotel1->setCity('dubai');
        $newHotel1->setAvailability([
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
        ]);

        $newHotel2 = new Hotel();
        $newHotel2->setName('Rotana Hotel');
        $newHotel2->setPrice(80.6);
        $newHotel2->setCity('cairo');
        $newHotel2->setAvailability([
            [
                "from" => "10-10-2020",
                "to" => "12-10-2020"
            ],
            [
                "from" => "25-10-2020",
                "to" => "10-11-2020"
            ],
            [
                "from" => "05-12-2020",
                "to" => "18-12-2020"
            ]
        ]);

        $newHotel3 = new Hotel();
        $newHotel3->setName('Le Meridien');
        $newHotel3->setPrice(89.6);
        $newHotel3->setCity('london');
        $newHotel3->setAvailability([
            [
                "from" => "01-10-2020",
                "to" => "12-10-2020"
            ],
            [
                "from" => "05-10-2020",
                "to" => "10-11-2020"
            ],
            [
                "from" => "05-12-2020",
                "to" => "28-12-2020"
            ]
        ]);

        return [$newHotel1,$newHotel2,$newHotel3];
    }
}
