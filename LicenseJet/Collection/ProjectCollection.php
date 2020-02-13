<?php namespace LicenseJet\Collection;

use LicenseJet\Endpoint\ProjectEndpoint;
use LicenseJet\Resource\Project;

/**
 * Project Collection.
 * 
 * @see ProjectEndpoint
 * 
 * Class ProjectCollection
 * @package LicenseJet\Collection
 */
Class ProjectCollection extends BaseCollection 
{
    /**
     * Retrieves all projects in the collection.
     * 
     * @return Project[]
     */
    public function all() : array
    {
        return parent::all();
    }
}