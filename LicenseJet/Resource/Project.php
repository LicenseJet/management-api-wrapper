<?php namespace LicenseJet\Resource;

/**
 * The Project Resource
 * 
 * Class Project
 * @package LicenseJet\Resource
 */
Class Project extends Resource
{
    /**
     * Get the project identifier.
     * 
     * @return string|null
     */
    public function getIdentifier() : ?string
    {
        return $this->getAttribute('identifier');
    }

    /**
     * Get the project name.
     * 
     * @return string|null
     */
    public function getName() : ?string
    {
        return $this->getAttribute('name');
    }

    /**
     * Get the project's latest public version.
     * 
     * @example: 1.23
     * 
     * @return string|null
     */
    public function getPublicVersion() : ?string
    {
        return $this->getAttribute('public_version');
    }

    /**
     * Get project manager.
     * 
     * @example: generic_php
     * 
     * @return string|null
     */
    public function getManager() : ?string
    {
        return $this->getAttribute('manager');
    }

    /**
     * Get project manager name.
     * 
     * @example: Generic PHP
     * 
     * @return string|null
     */
    public function getManagerName() : ?string
    {
        return $this->getAttribute('manager_name');
    }
}