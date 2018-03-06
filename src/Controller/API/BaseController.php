<?php

namespace App\Controller\API;


use App\API\ApiError;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends FOSRestController
{
    /**
     * @param ApiError $error
     * @return Response
     */
    protected function getErrorResponse(ApiError $error): Response
    {
        $serializer = $this->get('jms_serializer');
        $serializedData = $serializer->serialize($error->toArray(), 'json');

        return new Response($serializedData,$error->getStatusCode(),['content-type' => ApiError::CONTENT_TYPE_JSON_HEADER]);
    }

    /**
     * @param $data
     * @param int $httpStatus
     * @return Response
     */
    protected function getSuccessResponse($data, int $httpStatus = Response::HTTP_OK): Response
    {
        $serializer = $this->get('jms_serializer');
        $serializedData = $serializer->serialize($data, 'json');

        return new Response($serializedData,Response::HTTP_OK, ['content-Type' => 'application/json']);
    }
}