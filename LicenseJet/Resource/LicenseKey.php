<?php namespace LicenseJet\Resource;

use DateTime;

/**
 * The License Key Resource.
 * 
 * Class LicenseKey
 * @package LicenseJet\Resource
 */
Class LicenseKey extends Resource
{
    /**
     * Get the license ID associated with the license key.
     * 
     * @return int|null
     */
    public function getLicenseId() : ?int
    {
        if (is_null($this->getAttribute('license_id')))
        {
            return null;
        }

        return (int) $this->getAttribute('license_id');
    }

    /**
     * Set the license ID.
     * 
     * @param int $licenseId
     */
    public function setLicenseId(int $licenseId)
    {
        $this->setAttribute('license_id', $licenseId);
    }

    /**
     * Get the hostname of the license key.
     * 
     * @return string|null
     */
    public function getHost() : ?string
    {
        return $this->getAttribute('host');
    }

    /**
     * Set the hostname of the license key.
     * 
     * @param string|null $host
     */
    public function setHost(?string $host)
    {
        $this->setAttribute('host', $host);
    }

    /**
     * Get the license key.
     * 
     * @return string|null
     */
    public function getKey() : ?string
    {
        return $this->getAttribute('key');
    }

    /**
     * Get license status.
     * 
     * Values: active, suspended, terminated
     * 
     * @return string|null
     */
    public function getStatus() : ?string
    {
        if (is_null($this->getAttribute('status')))
        {
            return null;
        }

        return  $this->getAttribute('status');
    }

    /**
     * Get suspension reason.
     * 
     * @return string|null
     */
    public function getSuspensionReason() : ?string
    {
        return $this->getAttribute('suspension_reason');
    }

    public function getSuspensionExpirationDate() : ?DateTime
    {
        return $this->getDateTimeOrNull($this->getAttribute('suspension_expiration_date'));
    }

    /**
     * Get the date at which the license key was created.
     * 
     * @return DateTime|null
     */
    public function getCreatedDate() : ?DateTime
    {
        return $this->getDateTimeOrNull($this->getAttribute('created_date'));
    }
}