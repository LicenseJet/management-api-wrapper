<?php namespace LicenseJet\Endpoint;

use LicenseJet\Collection\BaseCollection;
use LicenseJet\Resource\Term;
use LicenseJet\RequestBuilder\CollectionRequestBuilder;

/**
 * The Term Endpoint.
 * 
 * Class TermEndpoint
 * @package LicenseJet\Endpoint
 */
Class TermEndpoint extends Endpoint
{
    /**
     * Retrieve the Terms.
     *
     * @return CollectionRequestBuilder
     */
    public function list() : CollectionRequestBuilder
    {
        return new CollectionRequestBuilder(
            $this->identity,
            $this,
            'terms',
            function ($term)
            {
                return Term::createFromArray((array) $term);
            },
            new BaseCollection()
        );
    }
}