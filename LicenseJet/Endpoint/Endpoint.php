<?php namespace LicenseJet\Endpoint;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use LicenseJet\Identity;
use LicenseJet\Response;
use LicenseJet\LicenseJetException;
use \Throwable;

/**
 * The Base API Endpoint.
 * 
 * Class Endpoint
 * @package LicenseJet\Endpoint
 */
Class Endpoint
{
    /**
     * The Identity used for authentication on the api server.
     * 
     * @var Identity 
     */
    public $identity;

    /**
     * Endpoint constructor.
     * 
     * @param Identity $identity
     */
    public function __construct(Identity $identity)
    {
        $this->identity = $identity;
    }

    /**
     * Sends the request to the api server and returns the Response.
     * Throws an exception if the request was unsuccessful due to either a local or remote error.
     * 
     * @param string $method
     * @param string $uri
     * @param array $queryParams
     * @return Response
     * @throws LicenseJetException
     */
    public function request(string $method, string $uri, array $queryParams = []) : Response
    {
        $method = strtoupper($method);

        // Retrieve GuzzleHttp client from Identity.
        $client = $this->identity->client();

        // Create request
        $request = new Request($method, $uri, [
            'Authorization' => 'APIKEY '.$this->identity->getKey(),
            'Accept' => 'application/json'
        ]);

        $options = [];

        if ($method == 'POST' && !empty($queryParams))
        {
            // Always send JSON request for POST
            $options[RequestOptions::JSON] = $queryParams;
        }
        elseif (!empty($queryParams))
        {
            // Append query params for GET
            $options[RequestOptions::QUERY] = $queryParams;
        }

        try
        {
            // return Response object on successful response
            return new Response($client->send($request, $options));
        }
        catch (ClientException $e)
        {
            // GuzzleHttp exceptions are transformed into LicenseJet Exception
            throw new LicenseJetException('Request failed: '.$e->getResponse()->getReasonPhrase(), null, $e);
        }
        catch (Throwable $e)
        {
            // Local exceptions are transformed into LicenseJet Exception
            throw new LicenseJetException('Request failed. Error: '.$e->getMessage(), null, $e);
        }
    }
}