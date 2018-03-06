<?php

namespace App\Controller\API;

use App\API\ApiError;
use App\Form\HotelSearchType;
use App\Service\AbstractHotelFetcher;
use App\Service\FormValidator;
use App\Service\HotelSearch;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class HotelController
 * @package App\Controller\API
 */
class HotelController extends BaseController
{
    /**
     * @param Request $request
     * @Rest\Get("/api/search/hotels")
     */
    public function searchHotels(Request $request)
    {

        $validationForm  = $this->createForm(HotelSearchType::class);
        $validationForm->submit($request->query->all());
        if(!$validationForm->isValid()) {
            $formValidator = $this->get("app.service.form_validator");
            $validationErrors = $formValidator->getFormErrors($validationForm);
            $apiError = new ApiError(Response::HTTP_BAD_REQUEST,ApiError::TYPE_VALIDATION);
            $apiError->addErrorsToExtraData($validationErrors);

            return $this->getErrorResponse($apiError);
        }

        $searchQuery = $validationForm->getData();

        /** @var HotelSearch $hotelSearch */
        $hotelSearch = $this->get("app.service.hotel_search");

        $hotels = $hotelSearch->searchHotels($searchQuery);

        return $this->getSuccessResponse($hotels);
    }
}