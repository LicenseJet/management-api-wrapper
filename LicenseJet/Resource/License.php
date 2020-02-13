<?php namespace LicenseJet\Resource;

use DateTime;

/**
 * The License Resource.
 * 
 * Class License
 * @package LicenseJet\Resource
 */
Class License extends Resource
{
    /**
     * Get License Type.
     * 
     * Values: subscription, perpetual
     *
     * @return null|string
     */
    public function getType() : ?string
    {
        return $this->getAttribute('type');
    }

    /**
     * Set the License Type.
     *
     * Values: subscription, perpetual
     * 
     * @param string $type
     */
    public function setType(string $type) : void
    {
        $this->setAttribute('type', $type);
    }

    /**
     * Get the subscription term.
     * 
     * @return Term|null
     */
    public function getSubscriptionTerm() : ?Term
    {
        if (!$this->isSubscription())
        {
            return null;
        }

        return Term::create(
            $this->getAttribute('subscription_term.identifier'),
            $this->getAttribute('subscription_term.length')
        );
    }

    /**
     * Set the subscription term.
     * 
     * @see Term::create()
     * 
     * @param Term $term
     */
    public function setSubscriptionTerm(Term $term) : void
    {
        $this->setAttribute('subscription_term', $term->toArray());
    }

    /**
     * Get the access key.
     * 
     * @return string|null
     */
    public function getAccessKey() : ?string
    {
        return $this->getAttribute('access_key');
    }

    /**
     * Set the access key.
     * 
     * @param string $accessKey
     */
    public function setAccessKey(string $accessKey) : void
    {
        $this->setAttribute('access_key', $accessKey);
    }

    /**
     * Get the status.
     * 
     * Example: active, expired, suspended, terminated
     * 
     * @return string|null
     */
    public function getStatus() : ?string
    {
        return $this->getAttribute('status');
    }

    /**
     * Set the status.
     *
     * Example: active, expired, suspended, terminated
     * 
     * @param string $status
     */
    public function setStatus(string $status) : void
    {
        $this->setAttribute('status', $status);
    }

    /**
     * Get the license key limit.
     * 
     * @return int|null
     */
    public function getKeyLimit() : ?int
    {
        if (is_null($this->getAttribute('key_limit')))
        {
            return null;
        }

        return (int) $this->getAttribute('key_limit');
    }

    /**
     * Set the license key limit.
     * 
     * @param int|null $keyLimit
     */
    public function setKeyLimit(?int $keyLimit) : void
    {
        $this->setAttribute('key_limit', $keyLimit);
    }

    /**
     * Get the expiration date.
     *
     * @return DateTime|null
     */
    public function getExpirationDate() : ?DateTime
    {
        return $this->getDateTimeOrNull($this->getAttribute('expiration_date'));
    }

    /**
     * Set the expiration date. 
     * Setting this to a null value will force the subscription license to expire until a date is set.
     * 
     * @param DateTime|null $dateTime
     */
    public function setExpirationDate(?DateTime $dateTime) : void
    {
        if ($dateTime)
        {
            $this->setAttribute('expiration_date', $dateTime->format(static::DATETIME_FORMAT));
        }
        else
        {
            $this->setAttribute('expiration_date', null);
        }
    }

    /**
     * Get the expiration date grace period.
     *
     * @return DateTime|null
     */
    public function getExpirationDateGracePeriod() : ?DateTime
    {
        return $this->getDateTimeOrNull($this->getAttribute('expiration_date_grace_period'));
    }

    /**
     * Set the expiration date grace period.
     *
     * @param DateTime|null $dateTime
     */
    public function setExpirationDateGracePeriod(?DateTime $dateTime) : void
    {
        if ($dateTime)
        {
            $this->setAttribute('expiration_date_grace_period', $dateTime->format(static::DATETIME_FORMAT));
        }
        else
        {
            $this->setAttribute('expiration_date_grace_period', null);
        }
    }

    /**
     * Check if the license is transferable.
     * 
     * @return bool
     */
    public function isTansferable() : bool
    {
        return $this->getAttribute('transferable') == 1;
    }

    /**
     * Set the transferable status of the license. 
     * 
     * Licensing Plan restrictions will still apply.
     * @see LicensingPlan::getTransferRestrictionTerm()
     * 
     * @param bool $transferable
     */
    public function setTransferable(bool $transferable) : void
    {
        $this->setAttribute('transferable', $transferable);
    }

    /**
     * Check if the license is ready for transfer. 
     * 
     * This takes into consideration the transferable status of the License and the License/Licensing Plan term restrictions.
     * @see LicensingPlan::getTransferRestrictionTerm()
     * 
     * @return bool
     */
    public function isTransferReady() : bool
    {
        return (bool) $this->getAttribute('transfer_ready');
    }

    /**
     * Get the date at which the license becomes transferable as per the Licensing Plan.
     * 
     * @return DateTime|null
     */
    public function getTransferableDate() : ?DateTime
    {
        return $this->getDateTimeOrNull($this->getAttribute('transferable_date'));
    }

    /**
     * Override the transferable date restriction on the license.
     * 
     * @param DateTime $dateTime
     */
    public function setTransferableDate(DateTime $dateTime) : void
    {
        $this->setAttribute('transferable_date', $dateTime->format(static::DATETIME_FORMAT));
    }

    /**
     * Get the user ID associated with the license.
     * 
     * @return int|null
     */
    public function getUserId() : ?int
    {
        if (is_null($this->getAttribute('user_id')))
        {
            return null;
        }

        return (int) $this->getAttribute('user_id');
    }

    /**
     * Set the user ID associated with the license.
     * 
     * @param int|null $userId
     */
    public function setUserId(?int $userId) : void
    {
        $this->setAttribute('user_id', $userId);
    }

    /**
     * Get the licensing plan ID.
     * 
     * @return int|null
     */
    public function getLicensingPlanId() : ?int
    {
        if (is_null($this->getAttribute('licensing_plan_id')))
        {
            return null;
        }

        return (int) $this->getAttribute('licensing_plan_id');
    }

    /**
     * Set the licensing plan by ID. 
     * This will not update the license properties to match the licensing plan.
     * 
     * @param int $licensingPlanId
     */
    public function setLicensingPlanId(int $licensingPlanId) : void
    {
        $this->setAttribute('licensing_plan_id', $licensingPlanId);
    }

    /**
     * Get the project ID.
     * 
     * @example: 1
     * 
     * @return int|null
     */
    public function getProjectId() : ?int
    {
        if (is_null($this->getAttribute('project_id')))
        {
           return null;
        }

        return (int) $this->getAttribute('project_id');
    }

    /**
     * Get the project identifier.
     * 
     * @example: CK3JVC
     * 
     * @return string|null
     */
    public function getProjectIdentifier() : ?string
    {
        return $this->getAttribute('project_identifier');
    }

    /**
     * Get the date at which the license was created.
     * 
     * @return DateTime|null
     */
    public function getCreatedDate() : ?DateTime
    {
        return $this->getDateTimeOrNull($this->getAttribute('created_date'));
    }

    /**
     * Get the update access restrictions. Returns an array containing restriction types as values.
     * 
     * @example: array('term', 'version')
     * 
     * @return array|null
     */
    public function getUpdateAccessRestrictions() : ?array
    {
        if (!is_array($this->getAttribute('update_access_restrictions')))
        {
            return null;
        }

        return $this->getAttribute('update_access_restrictions');
    }

    /**
     * Update the update access restrictions of the license.
     * 
     * @param array|null $restrictions
     */
    public function setUpdateAccessRestrictions(?array $restrictions)
    {
        $this->setAttribute('update_access_restrictions', $restrictions);
    }

    /**
     * Get the date at which the license's access to update expires.
     * 
     * @return DateTime|null
     */
    public function getUpdateAccessExpirationDate() : ?DateTime
    {
        return $this->getDateTimeOrNull($this->getAttribute('update_access_expiration_date'));
    }

    /**
     * Set the date at which the license's access to update expires. 
     * 
     * @param DateTime|null $dateTime
     */
    public function setUpdateAccessExpirationDate(?DateTime $dateTime)
    {
        if ($dateTime)
        {
            $this->setAttribute('update_access_expiration_date', $dateTime->format(static::DATETIME_FORMAT));
        }
        else
        {
            $this->setAttribute('update_access_expiration_date', null);
        }
    }

    /**
     * Get the update access expiration term associated with the license.
     * 
     * @example: Term(month, 2) means the license's update access is due to be renewed every 2 months
     * 
     * @return Term|null
     */
    public function getUpdateAccessExpirationTerm() : ?Term
    {
        return Term::create(
            $this->getAttribute('update_access_expiration_term.identifier'),
            $this->getAttribute('update_access_expiration_term.length')
        );
    }

    /**
     * Set the update access expiration term of the license.
     * 
     * @see Term::create()
     * 
     * @param Term $updateAccessExpirationTerm
     */
    public function setUpdateAccessExpirationTerm(Term $updateAccessExpirationTerm) : void
    {
        $this->setAttribute('update_access_expiration_term.identifier', $updateAccessExpirationTerm->getIdentifier());
        $this->setAttribute('update_access_expiration_term.length', $updateAccessExpirationTerm->getLength());
    }

    /**
     * Returns the version threshold for update access (inclusive).
     * 
     * @example: 3 means the license has access to updates until version 3, inclusive.
     * 
     * @return string|null
     */
    public function getUpdateAccessExpirationVersion() : ?string
    {
        return $this->getAttribute('update_access_expiration_version');
    }

    /**
     * Set the update access version threshold.
     * 
     * @param string|null $version
     */
    public function setUpdateAccessExpirationVersion(?string $version)
    {
        $this->setAttribute('update_access_expiration_version', $version);
    }

    /**
     * Get the date at which the license's suspension expires.
     * 
     * @return DateTime|null
     */
    public function getSuspensionExpirationDate() : ?DateTime
    {
        return $this->getDateTimeOrNull($this->getAttribute('suspension_expiration_date'));
    }

    /**
     * Get the suspension reason.
     * 
     * @return string|null
     */
    public function getSuspensionReason() : ?string
    {
        return $this->getAttribute('suspension_reason');
    }

    /**
     * Check whenever the license is subscription based.
     * 
     * @return bool
     */
    public function isSubscription() : bool
    {
        return $this->getType() == 'subscription';
    }

    /**
     * Checks whenever the license is permanent/perpetual.
     * 
     * @return bool
     */
    public function isPerpetual() : bool
    {
        return $this->getType() == 'perpetual';
    }

    /**
     * Checks whenever the license is permanent/perpetual.
     * 
     * @return bool
     */
    public function isPermanent() : bool
    {
        return $this->isPerpetual();
    }

    /**
     * Checks whenever the license is active.
     * 
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->getStatus() == 'active';
    }

    /**
     * Checks whenever the license is expired.
     * 
     * @return bool
     */
    public function isExpired() : bool
    {
        return $this->getStatus() == 'expired';
    }

    /**
     * Checks whenever the license is suspended.
     * 
     * @return bool
     */
    public function isSuspended() : bool
    {
        return $this->getStatus() == 'suspended';
    }
}