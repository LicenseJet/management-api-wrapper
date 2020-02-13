<?php namespace LicenseJet\Endpoint;

use LicenseJet\Collection\LicenseCollection;
use LicenseJet\LicenseJetException;
use LicenseJet\Resource\License;
use LicenseJet\RequestBuilder\CollectionRequestBuilder;

/**
 * The License Endpoint.
 * 
 * Class LicenseEndpoint
 * @package LicenseJet\Endpoint
 */
Class LicenseEndpoint extends Endpoint
{
    /**
     * Retrieves the licenses. It is recommended to work on this collection using the iterator.
     *
     * @return CollectionRequestBuilder
     */
    public function list() : CollectionRequestBuilder
    {
        return new CollectionRequestBuilder(
            $this->identity,
            $this,
            'licenses',
            function ($license) {
                return new License((array) $license);
            },
            new LicenseCollection()
        );
    }

    /**
     * Retrieve a License by it's ID.
     *
     * @param $licenseId
     * @return null|License
     * @throws LicenseJetException
     */
    public function get(int $licenseId) : License
    {
        $response = $this->request('GET', 'licenses/'.$licenseId, []);

        if ($response->isSuccessful())
        {
            return License::createFromArray((array) $response->getPayload());
        }

        throw new LicenseJetException('Failed to retrieve resource. Error: '.$response->getErrorMessage());
    }

    /**
     * Create a license.
     *
     * @param License $license
     * @return License
     * @throws LicenseJetException
     */
    public function create(License $license) : License
    {
        $response = $this->request('POST', 'licenses', $license->toArray());

        if ($response->isSuccessful())
        {
            return License::createFromArray((array) $response->getPayload());
        }

        throw new LicenseJetException('Failed to create resource. Error: '.$response->getErrorMessage());
    }

    /**
     * Update a license.
     *
     * @param License $license
     * @return License
     * @throws LicenseJetException
     */
    public function update(License $license) : License
    {
        $response = $this->request('POST', 'licenses/'.$license->getId(), $license->toArray());

        if ($response->isSuccessful())
        {
            return License::createFromArray((array) $response->getPayload());
        }

        throw new LicenseJetException('Failed to update resource. Error: '.$response->getErrorMessage());
    }

    /**
     * Send a renewal request for the license. Term and length can be supplied to override the current subscription term.
     * 
     * @param int $licenseId
     * @param string|null $term
     * @param int|null $length
     * @return License
     * @throws LicenseJetException
     */
    public function renew(int $licenseId, ?string $term = null, ?int $length = null) : License
    {
        $response = $this->request('PUT', 'licenses/'.$licenseId.'/renewals', [
            'term' => $term,
            'length' => $length
        ]);

        if ($response->isSuccessful())
        {
            return License::createFromArray((array) $response->getPayload());
        }

        throw new LicenseJetException('Failed to process renewal. Error: '.$response->getErrorMessage());
    }

    /**
     * Send an update access term renewal request for the license. Term and length can be supplied to override the current 
     * update access term.
     * 
     * @example: renew the license's update access for a month
     * 
     * @param int $licenseId
     * @param string $term
     * @param int $length
     * @return License
     * @throws LicenseJetException
     */
    public function renewUpdateAccessTerm(int $licenseId, string $term, int $length) : License
    {
        $response = $this->request('PUT', 'licenses/'.$licenseId.'/update_access/term/renewals', [
            'term' => $term,
            'length' => $length
        ]);

        if ($response->isSuccessful())
        {
            return License::createFromArray((array) $response->getPayload());
        }

        throw new LicenseJetException('Failed to process update access renewal. Error: '.$response->getErrorMessage());
    }

    /**
     * Sends a version update access version renewal request for the license.
     * 
     * @example: The license will have access to updates up to this version (inclusive).
     * 
     * @param int $licenseId
     * @param string $version
     * @return License
     * @throws LicenseJetException
     */
    public function renewUpdateAccessVersion(int $licenseId, string $version) : License
    {
        $response = $this->request('PUT', 'licenses/'.$licenseId.'/update_access/version/renewals', [
            'version' => $version
        ]);

        if ($response->isSuccessful())
        {
            return License::createFromArray((array) $response->getPayload());
        }

        throw new LicenseJetException('Failed to process update access renewal. Error: '.$response->getErrorMessage());
    }

    /**
     * Delete a License.
     *
     * @param License $license
     * @return bool
     * @throws LicenseJetException
     */
    public function delete(License $license) : bool
    {
        return $this->request('DELETE', 'licenses/'.$license->getId())->isSuccessful();
    }

    /**
     * Create a transfer request for the license.
     *
     * @param License $license
     * @param int|null $recipientUserId
     * @return License
     * @throws LicenseJetException
     */
    public function transfer(License $license, ?int $recipientUserId) : License
    {
        $response = $this->request('PUT','licenses/'.$license->getId().'/transfers', [
            'user_id' => $recipientUserId,
        ]);

        if ($response->isSuccessful())
        {
            return License::createFromArray((array) $response->getPayload());
        }

        throw new LicenseJetException('Failed to update resource. Error: '.$response->getErrorMessage());
    }
}