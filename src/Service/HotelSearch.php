<?php

namespace App\Service;


use App\Model\Hotel;

class HotelSearch
{
    /** @var AbstractHotelFetcher */
    protected $hotelFetcher;

    public function __construct(AbstractHotelFetcher $hotelFetcher)
    {
        $this->hotelFetcher = $hotelFetcher;
    }

    /**
     * @param array $searchQuery
     * @return array
     */
    public function searchHotels(array $searchQuery): array
    {
        $hotels = $this->hotelFetcher->getHotels();

        //var_dump($hotels);

        $result = array_reduce(
            $hotels,
            function (array $result,Hotel $hotel) use ($searchQuery) {
                $name = true;
                $city = true;
                $price = true;
                $availability = true;

                if(!empty($searchQuery['name']) && $searchQuery['name'] != $hotel->getName()) {
                    $name = false;
                }

                if(!empty($searchQuery['city']) && $searchQuery['city'] != $hotel->getCity()) {
                    $city = false;
                }

                if(!empty($searchQuery['price_from']) &&
                    !empty($searchQuery['price_to']) &&
                    ($searchQuery['price_from'] > $hotel->getPrice() || $searchQuery['price_to'] < $hotel->getPrice())
                ) {
                    $price = false;
                }

                if(!empty($searchQuery['date_from']) && !empty($searchQuery['date_to'])
                ) {
                    $availability = false;
                    $i=0;
                    foreach($hotel->getAvailability() as $availabilityPeriod) {
                        $from = date_create_from_format('d-m-Y',$availabilityPeriod['from']);
                        $to = date_create_from_format('d-m-Y',$availabilityPeriod['to']);

                        if(($searchQuery['date_from'] >= $from) && ($searchQuery['date_to'] <= $to)) {
                            $availability = true;
                            break;
                        }
                        $i++;
                    }
                }

                if($name && $city && $price && $availability) {
                    $result[] = $hotel;
                }

                return $result;
            },
            []
        );

        if(!empty($searchQuery['sort_by'])) {
            $this->sortHotelsBy($result, $searchQuery['sort_by']);
        }

        return $result;
    }

    /**
     * @param array $hotels
     * @param string $sortBy
     */
    public function sortHotelsBy(array &$hotels, string $sortBy): void
    {
        if(!empty($sortBy)) {
            usort($hotels,function (Hotel $a, Hotel $b) use ($sortBy) {
                switch ($sortBy) {
                    case 'name':
                        return $a->getName() > $b->getName();
                    case 'price':
                        return $a->getPrice() > $b->getPrice();
                    default:
                        return false;
                }
            });
        }
    }
}