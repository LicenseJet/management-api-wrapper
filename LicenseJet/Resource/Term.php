<?php namespace LicenseJet\Resource;

/**
 * The Term Resource.
 * 
 * Class Term
 * @package LicenseJet\Resource
 */
Class Term extends Resource
{
    /**
     * The term identifier.
     * 
     * @example: day
     * 
     * @return string|null
     */
    public function getIdentifier() : ?string
    {
        return $this->getAttribute('identifier');
    }

    /**
     * Get the length of the session.
     * 
     * @example: 1
     * 
     * @return int|null
     */
    public function getLength() : ?int
    {
        return $this->getAttribute('length');
    }

    /**
     * Get the term's singular name.
     *
     * @example: day
     *
     * @return string|null
     */
    public function getSingularName() : ?string
    {
        return $this->getAttribute('name.singular');
    }

    /**
     * Get the term's plural name.
     *
     * @example: days
     *
     * @return string|null
     */
    public function getPluralName() : ?string
    {
        return $this->getAttribute('name.plural');
    }

    /**
     * Create a term using an identifier and a term length.
     * 
     * @param string|null $identifier
     * @param int|null $length
     * @return Term
     */
    public static function create(?string $identifier, ?int $length) : Term
    {
        return new static([
            'identifier' => $identifier,
            'length' => $length
        ]);
    }

    /**
     * Get the term's estimated length in minutes.
     * 
     * @return int|null
     */
    public function getEstimatedMinutes() : ?int
    {
        return $this->getAttribute('length_estimate.minutes');
    }

    /**
     * Get the term's estimated length in hours.
     * 
     * @return int|null
     */
    public function getEstimatedHours() : ?int
    {
        return $this->getAttribute('length_estimate.hours');
    }

    /**
     * Get the term's estimated length in days.
     * 
     * @return int|null
     */
    public function getEstimatedDays() : ?int
    {
        return $this->getAttribute('length_estimate.days');
    }
}