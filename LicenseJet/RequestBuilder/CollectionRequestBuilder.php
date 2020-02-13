<?php namespace LicenseJet\RequestBuilder;

use LicenseJet\Collection\BaseCollection;
use LicenseJet\Collection\CollectionIterator;
use LicenseJet\Endpoint\Endpoint;
use LicenseJet\Identity;
use LicenseJet\LicenseJetException;
use Closure;

/**
 * The request builder to interact with collections (eg.: projects, licenses, etc.)
 * 
 * Class CollectionRequestBuilder
 * @package LicenseJet\RequestBuilder
 */
Class CollectionRequestBuilder
{
    /**
     * Identity on the api server.
     * @var Identity
     */
    protected $identity;

    /**
     * The endpoint the request is sent to.
     *
     * @var Endpoint
     */
    protected $endpoint;

    /**
     * Callback to transform the raw data into a Resource.
     *
     * @var \Closure|null
     */
    protected $callback;

    /**
     * Path on the endpoint.
     * 
     * @var string
     */
    protected $uri;

    /**
     * The Collection Object to hold the resources.
     * 
     * @var BaseCollection 
     */
    protected $collection;

    /**
     * Page number to retrieve.
     * 
     * @var int 
     */
    protected $page = 1;

    /**
     * The number of resources to retrieve.
     * 
     * @var int 
     */
    protected $resourceLimit = -1;

    /**
     * CollectionRequestBuilder constructor.
     * @param Identity $wrapper
     * @param Endpoint $endpoint
     * @param string $uri
     * @param \Closure|null $callback
     * @param BaseCollection $collection
     */
    public function __construct(Identity $wrapper, Endpoint $endpoint, string $uri, ?Closure $callback, BaseCollection $collection)
    {
        $this->identity = $wrapper;
        $this->uri = $uri;
        $this->endpoint = $endpoint;
        $this->callback = $callback;
        $this->collection = $collection;
    }

    /**
     * Set the page index.
     *
     * @param int $page
     * @return static
     */
    public function page(int $page) : self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Set the maximum number of resources to return.
     *
     * @param int|null $limit
     * @return static
     */
    public function limit(?int $limit) : self
    {
        $this->resourceLimit = $limit;

        return $this;
    }

    /**
     * Get the base request params.
     *
     * @return array
     */
    protected function getParams() : array
    {
        return [
            'limit' => $this->resourceLimit,
            'page' => $this->page
        ];
    }
    
    /**
     * Retrieve the results as a Collection. 
     * 
     * Use this with caution when working on large datasets (eg.: licenses, license keys), for these it is recommended
     * to use getIterator. @see getIterator
     * 
     * @param array $params
     * @param $response
     * @return BaseCollection
     * @throws LicenseJetException
     */
    function get(array $params = [], &$response = null) : BaseCollection
    {
        // Send request to the server
        $response = $this->endpoint->request('GET', $this->uri,
            array_merge($params, $this->getParams())
        );

        // Return an empty collection if the request has failed
        if (!$response->isSuccessful())
        {
            return $this->collection;
        }

        // Extract response contents
        $response_contents = $response->getPayload();

        // Expect the "results" attribute.
        if (!isset($response_contents['results']))
        {
            return $this->collection;
        }

        // Run the callback to map the collection items.
        // The callback function is used to transform raw data into Resource objects.
        if (is_callable($this->callback))
        {
            $return = array_map($this->callback, $response_contents['results']);
        }
        // Return raw data
        else
        {
            $return = $response_contents['results'];
        }

        // Set the items on the collection
        $this->collection->setItems($return);

        return $this->collection;
    }

    /**
     * Retrieve the results as a Collection Iterator. The iterator can be paginated to better handle large datasets
     * and memory constraints. A new request is only issued when the data is accessed.
     * 
     * @param int $resourcesPerRequest
     * @param array $params
     * @return CollectionIterator
     */
    function getIterator(int $resourcesPerRequest = 10, array $params = [])  : CollectionIterator
    {
        return new CollectionIterator($this, $params, 1, $resourcesPerRequest);
    }
}