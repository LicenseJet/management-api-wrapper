<?php namespace LicenseJet\Collection;

use LicenseJet\Resource\User;

Class UserCollection extends BaseCollection 
{
    /**
     * Retrieves all users in the collection.
     * 
     * @return User[]
     */
    public function all() : array
    {
        return parent::all();
    }
}