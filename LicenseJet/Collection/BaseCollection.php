<?php namespace LicenseJet\Collection;

use ArrayAccess;
use LicenseJet\Resource\Resource;

/**
 * A collection containing resources.
 * 
 * Class BaseCollection
 * @package LicenseJet\Collection
 */
Class BaseCollection implements ArrayAccess 
{
    /**
     * Items in Resource format.
     * 
     * @var array|Resource[]|null 
     */
    protected $items = [];

    /**
     * BaseCollection constructor.
     * 
     * @param array|null $items
     */
    public function __construct(array $items = null)
    {
        $this->items = $items ?: [];
    }

    /**
     * Returns contents of the collection in associative array format.
     * 
     * @example: [1 => ['id' => '...', 'name' => '...'], 2 => ['id' => '...', 'name' => '...']]
     * 
     * @return array
     */
    public function toArray() : array
    {
        return array_map(function (Resource $resource)
        {
            return $resource->toArray();
        }, $this->all());
    }

    /**
     * Set the items of the collection.
     * 
     * @param array $items
     */
    public function setItems(array $items) : void
    {
        $this->items = $items;
    }

    /**
     * Run the callback on the resources and return the result.
     * 
     * @param $callback
     * @return array|Resource[]
     */
    public function map($callback) : array
    {
        return array_map($callback, $this->all());
    }

    /**
     * Retrieves the number of items in the collection.
     * 
     * @return int
     */
    public function count() : int
    {
        return count($this->items);
    }

    /**
     * Returns the items of the collection.
     * 
     * @return array|Resource[]
     */
    public function all() : array
    {
        return $this->items;
    }

    /**
     * Checks for the existence of a Resource with the specified id.
     * 
     * @param int $resourceId
     * @return bool
     */
    public function contains(int $resourceId) : bool
    {
        $callback = function (Resource $model) use($resourceId)
        {
            return $model->getId() == $resourceId;
        };
        
        return count(array_filter($this->all(), $callback)) != 0;
    }

    /**
     * Whether a offset exists
     *
     * @param $offset
     * @return bool
     * @see ArrayAccess
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @param $offset
     * @return Resource|mixed
     * @see ArrayAccess
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * Offset to set
     *
     * @param $offset
     * @param $value
     * @see ArrayAccess
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    /**
     * Offset to unset
     *
     * @param $offset
     * @see ArrayAccess
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }
}