<?php

namespace App\Service;

use JMS\Serializer\Annotation as Serializer;

use App\Model\Hotel;
use Doctrine\Common\Collections\ArrayCollection;

class HotelApiFetcher extends AbstractHotelFetcher
{
    /**
     * @var AbstractRestClient
     */
    protected $restClient;

    /**
     * @var StringDeserializerInterface
     */
    protected $stringDeserializer;

    //this should be fetched from parameters
    const HOTEL_ENDPOINT = 'https://api.myjson.com/bins/tl0bp';

    public function __construct(AbstractRestClient $restClient, StringDeserializerInterface $stringDeserializer)
    {
        $this->restClient = $restClient;
        $this->stringDeserializer = $stringDeserializer;
    }

    public function getHotels(): array
    {
        $responseBody = $this->restClient->getResponseBody(self::HOTEL_ENDPOINT);
        //The type parameter in the next statement can be added to parameters to enable flexible change and can be implemented as a template class also
        //that represents the json structure returned for more rigid mapping
        $hotels = $this->stringDeserializer->deserializeString($responseBody,'array<array<'.Hotel::class.'>>');

        return count($hotels) > 0 ? $hotels[0] : [];
    }
}