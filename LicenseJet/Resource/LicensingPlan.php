<?php namespace LicenseJet\Resource;

use DateTime;

/**
 * The Licensing Plan Resource.
 * 
 * Class LicensingPlan
 * @package LicenseJet\Resource
 */
Class LicensingPlan extends Resource
{
    /**
     * Get the licensing plan identifier.
     *
     * @return string
     */
    public function getIdentifier() : ?string
    {
        return $this->getAttribute('identifier');
    }

    /**
     * Get the licensing plan name.
     *
     * @return string
     */
    public function getName() : ?string
    {
        return $this->getAttribute('name');
    }

    /**
     * Get the licensing plan type.
     * 
     * Values: subscription, perpetual
     *
     * @return string
     */
    public function getType() : ?string
    {
        return $this->getAttribute('type');
    }

    /**
     * Get the licensing plan text.
     * 
     * @return string|null
     */
    public function getText() : ?string
    {
        return $this->getAttribute('text');
    }

    /**
     * Check whenever the licenses under this plan are locked from transfer.
     * 
     * @return bool
     */
    public function getTransferLock() : bool
    {
        return $this->getAttribute('license_transfer_lock');
    }

    /**
     * Get the project identifier associated with the licensing plan.
     * 
     * @return string|null
     */
    public function getProjectIdentifier() : ?string
    {
        return $this->getAttribute('project_identifier');
    }

    /**
     * Get the project id associated with the licensing plan.
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
     * Get the project name associated with the licensing plan.
     * 
     * @return string|null
     */
    public function getProjectName() : ?string
    {
        return $this->getAttribute('project.name');
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
     * Retrieve the update access restrictions on the licensing plan.
     * 
     * @example: array('term', 'version)
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
     * Get update access expiration term.
     * 
     * @return Term|null
     */
    public function getUpdateAccessExpirationTerm() : ?Term
    {
        if (!$this->getAttribute('update_access_expiration_term.identifier'))
        {
            return null;
        }

        if (!$this->getAttribute('update_access_expiration_term.length'))
        {
            return null;
        }
        
        return Term::create(
            $this->getAttribute('update_access_expiration_term.identifier'),
            $this->getAttribute('update_access_expiration_term.length')
        );
    }

    /**
     * Get update access expiration version (inclusive).
     * 
     * @example: 1.23
     * 
     * @return string|null
     */
    public function getUpdateAccessExpirationVersion() : ?string
    {
        return $this->getAttribute('update_access_expiration_version');
    }

    /**
     * Get transfer restriction term.
     * 
     * @return Term|null
     */
    public function getTransferRestrictionTerm() : ?Term
    {
        if (!$this->getAttribute('transfer_restriction_term.identifier'))
        {
            return null;
        }

        if (!$this->getAttribute('transfer_restriction_term.length'))
        {
            return null;
        }

        return Term::create(
            $this->getAttribute('transfer_restriction_term.identifier'),
            $this->getAttribute('transfer_restriction_term.length')
        );
    }

    /**
     * Checks whenever the licensing plan is subscription based.
     * 
     * @return bool
     */
    public function isSubscription() : bool
    {
        return $this->getType() == 'subscription';
    }

    /**
     * Checks whenever the licensing plan is perpetual/permanent.
     *
     * @return bool
     */
    public function isPerpetual() : bool
    {
        return $this->getType() == 'perpetual';
    }

    /**
     * Checks whenever the licensing plan is perpetual/permanent.
     *
     * @return bool
     */
    public function isPermanent() : bool
    {
        return $this->isPerpetual();
    }

    /**
     * Get the date at which the licensing plan was created.
     * 
     * @return DateTime|null
     */
    public function getCreatedDate() : ?DateTime
    {
        return $this->getDateTimeOrNull($this->getAttribute('created_date'));
    }
}