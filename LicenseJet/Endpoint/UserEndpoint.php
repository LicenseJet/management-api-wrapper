<?php namespace LicenseJet\Endpoint;

use LicenseJet\LicenseJetException;
use LicenseJet\Resource\User;
use LicenseJet\Collection\UserCollection;
use LicenseJet\RequestBuilder\CollectionRequestBuilder;

/**
 * The user endpoint of the api server.
 * 
 * Class UserEndpoint
 * @package LicenseJet\Endpoint
 */
Class UserEndpoint extends Endpoint
{
    /**
     * Retrieve the user by user ID.
     *
     * @param int $userId
     * @return User
     * @throws LicenseJetException
     */
    public function get(int $userId) : User
    {
        $response = $this->request('GET', 'users/'.$userId);

        if ($response->isSuccessful())
        {
            return User::createFromArray((array) $response->getPayload());
        }

        throw new LicenseJetException('Failed to retrieve resource. Error: '.$response->getErrorMessage());
    }

    /**
     * Retrieve users using a request builder.
     * 
     * @return CollectionRequestBuilder
     */
    public function list() : CollectionRequestBuilder
    {
        return new CollectionRequestBuilder(
            $this->identity,
            $this,
            'users',
            function ($project) 
            {
                return new User((array) $project);
            },
            new UserCollection()
        );
    }

    /**
     * Create a user on the api server.
     * 
     * @param User $user
     * @return User
     * @throws LicenseJetException
     */
    public function create(User $user) : User
    {
        $response = $this->request('POST', 'users', $user->toArray());

        if ($response->isSuccessful())
        {
            return User::createFromArray((array) $response->getPayload());
        }

        throw new LicenseJetException('Failed to create resource. Error: '.$response->getErrorMessage());
    }
}