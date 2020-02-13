<?php namespace LicenseJet\Resource;

use DateTime;

/**
 * The base Resource used to interact with resources on the api server.
 * 
 * Class Resource
 * @package LicenseJet\Resource
 */
Abstract class Resource
{
    /**
     * The attributes of the resource.
     * 
     * @var array 
     */
    protected $attributes;

    /**
     * Original resource attributes (copy of $attributes when the resource is initialized).
     * 
     * @var array 
     */
    protected $originalAttributes;

    /**
     * The DateTime format used for string to DateTime conversions.
     */
    const DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * Resource constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->originalAttributes = $attributes;
    }

    /**
     * Get the ID of the resource.
     * 
     * @return int|null
     */
    public function getId() : ?int
    {
        return $this->attributes['id'];
    }

    /**
     * Retrieve the attributes of the resource as an array.
     * 
     * @return array
     */
    public function toArray() : array
    {
        return $this->attributes;
    }

    /**
     * Retrieve an attribute.
     * Supports dot access @see Resource::dotGet()
     * 
     * @param string $name
     * @param null $default
     * @return array|mixed
     */
    protected function getAttribute(string $name, $default = null)
    {
        return $this->dotGet($this->attributes, $name, $default);
    }

    /**
     * Set an attribute. 
     * Supports dot access @see Resource::dotSet()
     * 
     * @param string $name
     * @param $value
     */
    protected function setAttribute(string $name, $value) : void
    {
        $this->attributes = $this->dotSet($this->attributes, $name, $value);
    }

    /**
     * Fill the resource attributes using an array.
     * 
     * @param array $attributes
     * @return self
     */
    public function fill(array $attributes) : self
    {
        $this->attributes = array_merge($this->attributes, array_map(function ($attributes) {
            return $attributes;
        }, $attributes));

        return $this;
    }

    /**
     * Check if any changes were made to the resource using the modifiers.
     * 
     * @return bool
     */
    public function hasChanges() : bool
    {
        return !empty($this->changes());
    }

    /**
     * Compare the changed attributes with the original attributes and return the changed values as a key => value array.
     * 
     * @return array
     */
    public function changes() : array
    {
        $changes = [];

        foreach ($this->attributes as $key => $value)
        {
            if (!isset($this->originalAttributes[$key]) || $this->originalAttributes[$key] != $value)
            {
                $changes[$key] = $value;
            }
        }

        return $changes;
    }

    /**
     * Get an attribute using dot access.
     * 
     * @example: dotGet($data, 'subscription_term.length');
     * 
     * @param array $array
     * @param string $key
     * @param $default
     * @return array|mixed
     */
    public function dotGet(array $array, string $key, $default)
    {
        if (is_null($key))
        {
            return $array;
        }

        if (array_key_exists($key, $array))
        {
            return $array[$key];
        }

        if (strpos($key, '.') === false)
        {
            return $array[$key] ?? $default;
        }

        foreach (explode('.', $key) as $segment)
        {
            if (array_key_exists($segment, $array))
            {
                $array = $array[$segment];
            }
            else
            {
                return $default;
            }
        }

        return $array;
    }

    /**
     * Set an attribute using dot access (similar to laravel) and return the modified array.
     * 
     * @example: dotSet($data, 'subscription_term.length', 2)
     * 
     * @param array $array
     * @param string $key
     * @param $value
     * @return array
     */
    public function dotSet(array $array, string $key, $value) : array
    {
        $keys = explode('.', $key);
        $processed = 0;
        $data = &$array;

        foreach ($keys as $key)
        {
            $processed++;

            if (!isset($data[$key]) || !is_array($data[$key]))
            {
                $data[$key] = [];
            }

            $data = &$data[$key];
        }

        $data = $value;

        return $array;
    }

    /**
     * Create the resource from an array.
     * 
     * @param array $attributes
     * @return static
     */
    public static function createFromArray(array $attributes) : self
    {
        return new static($attributes);
    }

    /**
     * Convert value from the datetime format (@see static::DATETIME_FORMAT) to a DateTime object
     * 
     * @param $value
     * @return DateTime|null
     */
    public function getDateTimeOrNull($value) : ?DateTime
    {
        if (!$value)
        {
            return null;
        }

        $dateTime = DateTime::createFromFormat(static::DATETIME_FORMAT, $value);

        if ($dateTime)
        {
            return $dateTime;
        }

        return null;
    }

    /**
     * Retrieve a link from the _links property.
     * 
     * @param string $name
     * @return string|null
     */
    public function link($name = 'self') : ?string
    {
        $links = $this->getAttribute('_links', []);

        if (isset($links->$name))
        {
            return $links->$name;
        }

        return null;
    }
}