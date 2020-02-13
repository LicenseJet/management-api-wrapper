<?php namespace LicenseJet\Endpoint;

use LicenseJet\Collection\LicenseKeyCollection;
use LicenseJet\LicenseJetException;
use LicenseJet\Resource\LicenseKey;
Use LicenseJet\RequestBuilder\CollectionRequestBuilder;

/**
 * The License Key endpoint.
 * 
 * Class LicenseKeyEndpoint
 * @package LicenseJet\Endpoint
 */
Class LicenseKeyEndpoint extends Endpoint
{

    /**
     * Retrieves the license keys. It is recommended to work on this collection using the iterator.
     *
     * @return CollectionRequestBuilder
     */
    public function list() : CollectionRequestBuilder
    {
        return new CollectionRequestBuilder(
            $this->identity,
            $this,
            'license_keys',
            function ($attributes) 
            {
                return new LicenseKey((array) $attributes);
            },
            new LicenseKeyCollection()
        );
    }
    
    /**
     * Retrieve a license key by it's ID.
     * 
     * @param $licenseKeyId
     * @return LicenseKey
     * @throws LicenseJetException
     */
    public function get(int $licenseKeyId) : LicenseKey
    {
        $response = $this->request('GET', 'license_keys/'.$licenseKeyId, []);

        if ($response->isSuccessful())
        {
            return LicenseKey::createFromArray((array) $response->getPayload());
        }

        throw new LicenseJetException('Failed to retrieve resource. Error: '.$response->getErrorMessage());
    }

    /**
     * Delete a license key.
     *
     * @param LicenseKey $licenseKey
     * @return bool
     * @throws LicenseJetException
     */
    public function delete(LicenseKey $licenseKey) : bool
    {
        return $this->request('DELETE', 'license_keys/'.$licenseKey->getKey())->isSuccessful();
    }

    /**
     * Create a license key.
     * 
     * @param LicenseKey $licenseKey
     * @return LicenseKey
     * @throws LicenseJetException
     */
    public function create(LicenseKey $licenseKey) : LicenseKey
    {
        $response = $this->request('POST', 'license_keys', $licenseKey->toArray());

        if ($response->isSuccessful())
        {
            return LicenseKey::createFromArray((array) $response->getPayload());
        }

        throw new LicenseJetException('Failed to create resource. Error: '.$response->getErrorMessage());
    }
}