<?php namespace LicenseJet\Endpoint;

use LicenseJet\LicenseJetException;
use LicenseJet\Resource\Project;
use LicenseJet\Collection\ProjectCollection;
use LicenseJet\RequestBuilder\CollectionRequestBuilder;

/**
 * The Project Endpoint
 * 
 * Class ProjectEndpoint
 * @package LicenseJet\Endpoint
 */
Class ProjectEndpoint extends Endpoint
{
    /**
     * Retrieve projects using a request builder.
     * 
     * @return CollectionRequestBuilder
     */
    public function list() : CollectionRequestBuilder
    {
        return new CollectionRequestBuilder(
            $this->identity,
            $this,
            'projects',
            function ($project) 
            {
                return new Project((array) $project);
            },
            new ProjectCollection()
        );
    }

    /**
     * Retrieve a project by it's ID.
     * 
     * @param int $projectId
     * @return Project
     * @throws LicenseJetException
     */
    public function get(int $projectId) : Project
    {
        $response = $this->request('GET', 'projects/'.$projectId, []);

        if ($response->isSuccessful())
        {
            return Project::createFromArray((array) $response->getPayload());
        }

        throw new LicenseJetException('Failed to retrieve resource. Error: '.$response->getErrorMessage());
    }

    /**
     * Update a project.
     * 
     * @param Project $project
     * @return Project
     * @throws LicenseJetException
     */
    public function update(Project $project) : Project
    {
        $response = $this->request(
            'POST',
            'projects/'.$project->getId(),
            $project->toArray()
        );

        if ($response->isSuccessful())
        {
            return Project::createFromArray((array) $response->getPayload());
        }

        throw new LicenseJetException('Failed to update resource. Error: '.$response->getErrorMessage());
    }
}