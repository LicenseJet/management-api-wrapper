<?php namespace LicenseJet\Resource;

/**
 * The User Resource.
 * 
 * Class User
 * @package LicenseJet\Resource
 */
Class User extends Resource
{
    /**
     * Get the email of the user.
     *
     * @return mixed|null
     */
    public function getEmail() : ?string
    {
        return $this->getAttribute('email');
    }

    /**
     * Set the user's email.
     * 
     * @param string $email
     */
    public function setEmail(string $email) : void
    {
        $this->setAttribute('email', $email);
    }

    /**
     * Get the user's name.
     * 
     * @return string|null
     */
    public function getName() : ?string
    {
        return $this->getAttribute('name');
    }

    /**
     * Set the user's name.
     * 
     * @param string $name
     */
    public function setName(string $name) : void
    {
        $this->setAttribute('name', $name);
    }

    /**
     * Check if the user can authenticate with LicenseJet (eg.: administrators).
     * 
     * @return bool
     */
    public function getAuthentication() : bool
    {
        return $this->getAttribute('authentication') == 1;
    }

    /**
     * Set the authentication status of the user. False means the user shouldn't be allowed to log in.
     * 
     * @param bool $authentication
     */
    public function setAuthentication(bool $authentication) : void
    {
        $this->setAttribute('authentication', $authentication);
    }

    /**
     * Set the user's password.
     * 
     * @param string $password
     */
    public function setPassword(string $password) : void
    {
        $this->setAttribute('password', $password);
    }
}