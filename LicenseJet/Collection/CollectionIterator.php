<?php namespace LicenseJet\Collection;

use Iterator;
use LicenseJet\LicenseJetException;
use LicenseJet\RequestBuilder\CollectionRequestBuilder as RequestBuilder;
use LicenseJet\Resource\Resource;

/**
 * The Collection Iterator. Optimised to be used on large datasets.
 * 
 * Implements the Iterator interface to allow usage in loops.
 * 
 * Class CollectionIterator
 * @package LicenseJet\Collection
 */
Class CollectionIterator implements Iterator
{
    /**
     * Request Builder instance.
     * 
     * @var RequestBuilder 
     */
    protected $requestBuilder;

    /**
     * Parameters to be passed with every request.
     * 
     * @var array 
     */
    protected $params;

    /**
     * Current page.
     * 
     * @var int 
     */
    protected $page;

    /**
     * @var int 
     */
    protected $resourcesPerRequest;

    /**
     * @var BaseCollection
     */
    protected $data = null;

    /**
     * Index of the current resource on the current request.
     * 
     * @var int 
     */
    private $currentResourcePosition = 0;

    /**
     * CollectionIterator constructor.
     * @param RequestBuilder $requestBuilder
     * @param array $params
     * @param int $page
     * @param int $resourcesPerRequest
     */
    public function __construct(RequestBuilder $requestBuilder, array $params, int $page, int $resourcesPerRequest)
    {
        $this->requestBuilder = $requestBuilder;
        $this->params = $params;
        $this->page = $page;
        $this->resourcesPerRequest = $resourcesPerRequest;
    }

    /**
     * @return BaseCollection
     * @throws LicenseJetException
     */
    private function requestData() : BaseCollection
    {
        if ($this->data === null)
        {
            // No data is available, send a request to the api to retrieve the current page
            $this->data = $this->requestBuilder
                ->page($this->page)
                ->limit($this->resourcesPerRequest)
                ->get($this->params);
        }

        // Make sure we have a Collection response
        if ($this->data instanceof BaseCollection)
        {
            return $this->data;
        }

        throw new LicenseJetException('Iterator error. Failed to retrieve page #'.$this->page.' due to malformed response.');
    }

    /**
     * Reset the current data.
     */
    private function resetData()
    {
        $this->data = null;
    }

    /**
     * Return all items on the same request. Use with caution on large data sets!
     *
     * @return array|Resource[]
     * @throws LicenseJetException
     */
    public function all() : array
    {
        return $this->requestBuilder
                    ->page($this->page)
                    ->limit(-1)
                    ->get($this->params)
                    ->all();
    }

    /**
     * Retrieves the current entries.
     * 
     * @return array|null
     * @throws LicenseJetException
     */
    public function entries() : ?array
    {
        return $this->requestData()
            ->all();
    }

    /**
     * Rewind iterator to the first page.
     * 
     * @see Iterator
     * @throws LicenseJetException
     */
    public function rewind()
    {
        $this->currentResourcePosition = 0;

        if ($this->page != 1)
        {
            $this->resetData();
        }

        $this->requestData();
    }

    /**
     * Returns current entry.
     * 
     * @see Iterator
     * @return Resource|mixed
     * @throws LicenseJetException
     */
    public function current()
    {
        $data = $this->requestData();

        return $data[$this->currentResourcePosition];
    }

    /**
     * Moves to iterator forward.
     * @see Iterator
     */
    public function next()
    {
        if ($this->currentResourcePosition == $this->resourcesPerRequest - 1)
        {
            $this->page++;
            $this->currentResourcePosition = 0;
            $this->resetData();
        }
        else
        {
            $this->currentResourcePosition++;
        }
    }

    /**
     * Check if there is an item on the current position.
     * 
     * @see Iterator
     * @return bool
     * @throws LicenseJetException
     */
    public function valid() : bool
    {
        $data = $this->requestData();

        return $this->currentResourcePosition < $data->count() && isset($data[$this->currentResourcePosition]);
    }

    /**
     * Returns the key of the current position. This is not the resource ID and it is only unique within the current page.
     * 
     * @return int
     */
    public function key()
    {
        return $this->currentResourcePosition;
    }

    /**
     * Return current page as raw array.
     * 
     * @return array
     * @throws LicenseJetException
     */
    public function toArray() : array
    {
        $data = $this->requestData();

        if ($data instanceof BaseCollection)
        {
            return $data->toArray();
        }

        return [];
    }
}