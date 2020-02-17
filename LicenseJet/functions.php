<?php

use LicenseJet\Collection\LicenseCollection;
use LicenseJet\Collection\ProjectCollection;
use LicenseJet\Endpoint\ProjectEndpoint;
use LicenseJet\Endpoint\RootEndpoint;
use LicenseJet\Identity;
use LicenseJet\LicenseJetException;

if (!function_exists('licensejet_get_projects'))
{
    /**
     * Retrieves all projects.
     *
     * @param $apiUrl
     * @param $apiKey
     * @return ProjectCollection
     * @throws LicenseJetException
     */
    function licensejet_get_projects(string $apiUrl, string $apiKey) : ProjectCollection
    {
        $projects = new ProjectEndpoint(new Identity($apiUrl, $apiKey));
        
        $response = $projects->list()->get();
        
        // Make sure we have a valid response
        if ($response instanceof ProjectCollection)
        {
            return $response;
        }
        
        throw new LicenseJetException('Couldn\'t retrieve projects. Malformed return data.');
    }
}

if (!function_exists('licensejet_get_permissions'))
{
    /**
     * Retrieves the permissions granted for the API Key.
     *
     * @param $baseApiUrl
     * @param $apiKey
     * @return array|null
     * @throws LicenseJetException
     */
    function licensejet_get_permissions(string $baseApiUrl, string $apiKey) : ?array
    {
        $identity = new Identity($baseApiUrl, $apiKey);

        return (new RootEndpoint($identity))->permissions();
    }
}