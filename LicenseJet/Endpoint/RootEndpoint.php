<?php namespace LicenseJet\Endpoint;

use LicenseJet\LicenseJetException;

/**
 * The API root. Contains information about the API and the current API Key.
 * 
 * Class RootEndpoint
 * @package LicenseJet\Endpoint
 */
Class RootEndpoint extends Endpoint
{
    /**
     * Retrieves API Key permissions.
     * 
     * @return array|null
     * @throws LicenseJetException
     */
    public function permissions() : ?array
    {
        if ($apiRoot = $this->request('GET', $this->identity->getUrl('/')))
        {
            $payload = $apiRoot->getPayload();

            if (isset($payload['permissions']) && is_array($payload['permissions']))
            {
                return $payload['permissions'];
            }
        }

        return null;
    }
}