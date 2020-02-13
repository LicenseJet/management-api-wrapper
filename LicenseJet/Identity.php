<?php /** @noinspection PhpUndefinedClassInspection */

namespace LicenseJet;

use GuzzleHttp\Client;

Class Identity
{
    /**
     * The base url of the api on the api server.
     * 
     * Example: https://yourservice.com/management/v1/
     * 
     * @var string 
     */
    protected $apiBaseUrl;

    /**
     * The API Key on the api server.
     * 
     * @var string 
     */
    protected $apiKey;

    /**
     * Timeout of the GuzzleHttp Client
     * 
     * @var int 
     */
    protected $clientTimeout = 10;

    /**
     * @var Client
     */
    protected $client;

    public function __construct(string $apiBaseUrl, string $apiKey, $clientTimeout = 10)
    {
        $this->apiBaseUrl = $apiBaseUrl;
        $this->apiKey = $apiKey;
        $this->clientTimeout = $clientTimeout;
    }

    /**
     * Retrieves the GuzzleHttp Client to be used for the connection.
     * 
     * @return Client
     */
    public function client() : Client
    {
        return new Client([
            'base_uri' => $this->apiBaseUrl,
            'timeout' => $this->getClientTimeout(),
            'headers' => [
                'Authorization' => 'APIKEY '.$this->apiKey
            ]
        ]);
    }

    /**
     * Retrieves the URL of the API Server. 
     * The $path parameter may be used to retrieve the url of an endpoint.
     * 
     * @param string $path
     * @return string
     */
    public function getUrl($path = '') : string
    {
        return $this->apiBaseUrl.'/'.$this->normalizeUrl($path);
    }

    /**
     * Retrieves the API Key.
     * 
     * @return string
     */
    public function getKey() :string
    {
        return $this->apiKey;
    }

    /**
     * Normalize the URL.
     * 
     * @param string $url
     * @return string
     */
    protected function normalizeUrl(string $url) : string
    {
        while (strpos($url, "//") !== false)
        {
            $url = str_replace("//", "/", $url);
        }

        return $url;
    }

    /**
     * Retrieve the timeout of the GuzzleHttp Client.
     * 
     * @return int
     */
    public function getClientTimeout(): int
    {
        return $this->clientTimeout;
    }

    /**
     * Set the timeout of the GuzzleHttp Client.
     * 
     * @param int $clientTimeout
     */
    public function setClientTimeout(?int $clientTimeout)
    {
        $this->clientTimeout = $clientTimeout;
    }

}