<?php namespace LicenseJet\Endpoint;

use LicenseJet\Collection\ProjectOptionCollection;
use LicenseJet\Resource\ProjectOption;
use LicenseJet\RequestBuilder\CollectionRequestBuilder;

/**
 * The project options endpoint.
 * 
 * Class ProjectOptionEndpoint
 * @package LicenseJet\Endpoint
 */
Class ProjectOptionEndpoint extends Endpoint
{
    /**
     * Retrieves the project options.
     * 
     * @return CollectionRequestBuilder
     */
    public function list() : CollectionRequestBuilder
    {
        return new CollectionRequestBuilder(
            $this->identity,
            $this,
            'project_options',
            function ($project) 
            {
                return new ProjectOption((array) $project);
            },
            new ProjectOptionCollection()
        );
    }
}