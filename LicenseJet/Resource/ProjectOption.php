<?php namespace LicenseJet\Resource;

/**
 * The Project Option Resource.
 * 
 * Class ProjectOption
 * @package LicenseJet\Resource
 */
Class ProjectOption extends Resource
{
    /**
     * Get the project option's name.
     * 
     * @return string|null
     */
    public function getName() : ?string
    {
        return $this->getAttribute('name');
    }

    /**
     * Get the project option's identifier.
     * 
     * @return string|null
     */
    public function getIdentifier() : ?string
    {
        return $this->getAttribute('identifier');
    }

    /**
     * Get the project option's default value.
     * 
     * @return string|null
     */
    public function getDefaultValue() : ?string
    {
        return $this->getAttribute('default_value');
    }

    /**
     * Get the project option's type.
     * 
     * @return string|null
     */
    public function getType() : ?string
    {
        return $this->getAttribute('type');
    }
}