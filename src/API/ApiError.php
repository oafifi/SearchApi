<?php

namespace App\API;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class ApiError
 * @package App\API
 *
 * This class adopts The Problem Details for HTTP APIs proposed standand https://tools.ietf.org/html/rfc7807
 */
class ApiError
{
    const CONTENT_TYPE_JSON_HEADER = 'application/problem+json';

    const TYPE_VALIDATION = 'validation_error';

    const TYPE_TITLE_MAP = [
        self::TYPE_VALIDATION => 'There is a validation error'
    ];

    private $statusCode;

    private $type;

    private $title;

    private $extraData = array();

    public function __construct(int $statusCode, string $type)
    {
        $this->statusCode = $statusCode;
        $this->type = $type;

        if(!array_key_exists($type,self::TYPE_TITLE_MAP)) {
            throw new \InvalidArgumentException('No title for argument type of value = '.$type);
        }

        $this->title = self::TYPE_TITLE_MAP[$type];
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function getExtraData(): array
    {
        return $this->extraData;
    }

    /**
     * @param array $errors
     */
    public function addErrorsToExtraData(array $errors) {
        $this->extraData['errors'] = $errors;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function addExtraData(string $key, $value) {
        $this->extraData[$key] = $value;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_merge([
            'status_code' => $this->statusCode,
            'type' => $this->type,
            'title' => $this->title
            ],
            $this->extraData
        );
    }

}