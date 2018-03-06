<?php

namespace App\Tests\API;

use App\API\ApiError;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ApiErrorTest extends TestCase
{

    public function testConstructorInvalidType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $apiError = new ApiError(400, 'non_existent_type');
    }

    /**
     * @return ApiError
     */
    public function testConstructor() {
        $apiError = new ApiError(400, ApiError::TYPE_VALIDATION);

        $this->assertAttributeNotEmpty('title',$apiError);

        return $apiError;
    }

    /**
     * @param ApiError $apiError
     * @depends testConstructor
     */
    public function testGetStatusCode(ApiError $apiError)
    {
        $this->assertEquals(400, $apiError->getStatusCode());
    }

    /**
     * @param ApiError $apiError
     * @depends testConstructor
     * @return ApiError
     */
    public function testAddErrorsToExtraData(ApiError $apiError)
    {
        $apiError->addErrorsToExtraData(['test_error']);

        $this->assertArrayHasKey('errors', $apiError->getExtraData());

        return $apiError;
    }

    /**
     * @param ApiError $apiError
     * @depends testAddErrorsToExtraData
     * @return ApiError
     */
    public function testAddExtraData(ApiError $apiError)
    {
        $apiError->addExtraData('test_data','test data details');

        $this->assertArrayHasKey('test_data', $apiError->getExtraData());

        return $apiError;
    }

    /**
     * @param ApiError $apiError
     * @depends testAddExtraData
     */
    public function testToArray(ApiError $apiError)
    {
        $array = $apiError->toArray();

        $this->assertArrayHasKey('status_code',$array);
        $this->assertArrayHasKey('type',$array);
        $this->assertArrayHasKey('title',$array);
        $this->assertArrayHasKey('errors',$array);
        $this->assertArrayHasKey('test_data',$array);
    }
}
