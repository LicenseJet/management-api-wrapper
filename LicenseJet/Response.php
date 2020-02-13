<?php namespace LicenseJet;

use Psr\Http\Message\ResponseInterface;

Class Response
{
    /**
     * The payload of the response.
     * 
     * @var mixed 
     */
    private $payload = null;

    /**
     * The raw http response.
     * 
     * @var ResponseInterface 
     */
    private $httpResponse;

    /**
     * Status code helpers to determine whenever the request was successful.
     * 
     * @var int 
     */
    static $STATUS_OK = 200;
    static $STATUS_NOT_CHANGED = 304;

    /**
     * Response constructor.
     * @param ResponseInterface $httpResponse
     */
    public function __construct(ResponseInterface $httpResponse)
    {
        // Store raw contents by default
        $this->payload = $httpResponse->getBody()->getContents();

        // Raw http response
        $this->httpResponse = $httpResponse;

        // Decode JSON response
        if ($httpResponse && is_array($httpResponse->getHeader('Content-Type')))
        {
            // Make sure the decoding is applicable
            if (in_array('application/json', $httpResponse->getHeader('Content-Type')))
            {
                $this->payload = json_decode($this->payload, true);
            }
        }
    }

    /**
     * Retrieves the error message from the status message. 
     * Returns null if the response is successful or if the status message is not available.
     * 
     * @return string|null
     */
    public function getErrorMessage() : ?string
    {
        if ($this->isSuccessful())
        {
            return null;
        }
        
        if ($this->httpResponse)
        {
            return $this->httpResponse->getReasonPhrase();
        }

        return null;
    }

    /**
     * Retrieves the response payload or, when not available, the specified default value.
     * JSON payloads are decoded and converted to associative arrays.
     * 
     * @param array $default
     * @return array|mixed
     */
    public function getPayload($default = [])
    {
        return $this->payload ?: $default;
    }

    /**
     * Retrieves the response status code.
     * 
     * @return int|null
     */
    public function getStatusCode() : ?int
    {
        return $this->httpResponse ? $this->httpResponse->getStatusCode() : null;
    }

    /**
     * Checks whenever the response is associated with a success status: OK, NOT CHANGED.
     * 
     * @return bool
     */
    public function isSuccessful() : bool
    {
        return in_array($this->getStatusCode(), [static::$STATUS_OK, static::$STATUS_NOT_CHANGED]);
    }
}