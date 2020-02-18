<?php namespace LicenseJet;

use GuzzleHttp\Exception\ClientException;
Use Exception;
use GuzzleHttp\Exception\RequestException;
use Throwable;

/**
 * The LicenseJet Exception. This is thrown through the library for both local and remote errors.
 * 
 * Class LicenseJetException
 * @package LicenseJet
 */
Class LicenseJetException extends Exception
{
    /**
     * LicenseJetException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        // Decode response body if possible
        if ($previous instanceof RequestException)
        {
            $response = $previous->getResponse();

            // Response is not available
            if (!$response)
            {
                return;
            }

            // Decode JSON response if possible
            if ($response && is_array($response->getHeader('Content-Type')))
            {
                // Make sure the decoding is applicable
                if (in_array('application/json', $response->getHeader('Content-Type')))
                {
                    $payload = @json_decode($response->getBody()->getContents());

                    if ($payload && isset($payload->error))
                    {
                        $this->message = $payload->error;
                    }
                }
            }
        }
    }
    
    /**
     * Determines if the exception was thrown due to the resource not being found on the service.
     * 
     * @return bool|null
     */
    public function isNotFound() : bool
    {
        $previous = $this->getPrevious();

        if ($previous instanceof $this)
        {
            return $previous->isNotFound();
        }

        if ($previous instanceof ClientException)
        {
            return $previous->getResponse()->getStatusCode() == 404;
        }

        return false;
    }
}