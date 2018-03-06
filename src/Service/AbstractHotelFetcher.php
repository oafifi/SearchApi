<?php

namespace App\Service;


abstract class AbstractHotelFetcher
{
    public abstract function getHotels(): array ;
}