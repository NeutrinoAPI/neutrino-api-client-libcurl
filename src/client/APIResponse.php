<?php

namespace NeutrinoAPI;

/**
 * API response payload, holds the response data along with any error details
 */
class APIResponse
{

    /**
     * @var array $data
     */
    private $data;

    /**
     * @var string $file
     */
    private $file;

    /**
     * @var int $statusCode
     */
    private $statusCode;

    /**
     * @var string $contentType
     */
    private $contentType;

    /**
     * @var int $errorCode
     */
    private $errorCode;

    /**
     * @var string $errorMessage
     */
    private $errorMessage;

    /**
     * @var string $errorCause
     */
    private $errorCause;

    /**
     * Constructor
     *
     * @param int $statusCode The HTTP response status code
     * @param string $contentType The HTTP response content type
     * @param array|null $data JSON data
     * @param string|null $file Path to downloaded temporary file
     * @param int|null $errorCode Unique Neutrino API error code
     * @param string|null $errorMessage A Neutrino API error message
     * @param string|null $errorCause A string representation of the exception
     */
    private function __construct(int $statusCode, string $contentType, ?array $data, ?string $file, ?int $errorCode, ?string $errorMessage, ?string $errorCause)
    {
        $this->statusCode = $statusCode;
        $this->contentType = $contentType;
        $this->data = $data;
        $this->file = $file;
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
        $this->errorCause = $errorCause;
    }

    /**
     * Was this request successul
     * 
     * @return boolean
     */
    function isOK(): bool
    {
        return isset($this->data) || isset($this->file);
    }

    /**
     * The response data for JSON based APIs
     * 
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * The local file path storing the output for file based APIs
     * 
     * @return string|null
     */
    public function getFile(): ?string
    {
        return $this->file;
    }

    /**
     * The HTTP status code returned
     * 
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * The response content type (MIME type)
     * 
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * The API error code if any error has occurred
     * 
     * @return int|null
     */
    public function getErrorCode(): ?int
    {
        return $this->errorCode;
    }

    /**
     * The API error message if any error has occurred
     * 
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * For client-side errors or exceptions get the underlying cause
     * 
     * @return string|null
     */
    public function getErrorCause(): ?string
    {
        return $this->errorCause;
    }

    /**
     * Create an API response for JSON data
     *
     * @param int $statusCode
     * @param string $contentType
     * @param array $data JSON data
     * @return APIResponse
     */
    static function ofData(int $statusCode, string $contentType, array $data): APIResponse
    {
        return new APIResponse($statusCode, $contentType, $data, null, null, null, null);
    }

    /**
     * Create an API response for file data
     *
     * @param int $statusCode
     * @param string $contentType
     * @param string $outputFilePath Path to downloaded temporary file
     * @return APIResponse
     */
    static function ofOutputFilePath(int $statusCode, string $contentType, string $outputFilePath): APIResponse
    {
        return new APIResponse($statusCode, $contentType, null, $outputFilePath, null, null, null);
    }

    /**
     * Create an API response for error code
     *
     * @param int $statusCode
     * @param string $contentType
     * @param int $errorCode error APIError error code
     * @return APIResponse
     */
    static function ofErrorCode(int $statusCode, string $contentType, int $errorCode): APIResponse
    {
        $errorMessage = APIErrorCode::getErrorMessage($errorCode);
        return new APIResponse($statusCode, $contentType, null, null, $errorCode, $errorMessage, null);
    }

    /**
     * Create an API response for error cause
     *
     * @param int $errorCode error APIError error code
     * @param string $errorCause
     * @return APIResponse
     */
    static function ofErrorCause(int $errorCode, string $errorCause): APIResponse
    {
        $errorMessage = APIErrorCode::getErrorMessage($errorCode);
        return new APIResponse(0, "", null, null, $errorCode, $errorMessage, $errorCause);
    }

    /**
     * Create an API response for status code
     *
     * @param int $statusCode
     * @param string $contentType
     * @param int $errorCode NeutrinoAPI response error code
     * @param string $errorMessage NeutrinoAPI response error message
     * @return APIResponse
     */
    static function ofHttpStatus(int $statusCode, string $contentType, int $errorCode, string $errorMessage): APIResponse
    {

        return new APIResponse($statusCode, $contentType, null, null, $errorCode, $errorMessage, null);
    }
}
