<?php namespace LicenseJet;

use GuzzleHttp\Exception\ClientException;
Use Exception;

/**
 * The LicenseJet Exception. This is thrown through the library for both local and remote errors.
 * 
 * Class LicenseJetException
 * @package LicenseJet
 */
Class LicenseJetException extends Exception
{
    /**
     * Determines if the exception was thrown due to the resource not being found on the service.
     * 
     * @return bool|null
     */
    public function isNotFound() : bool
    {
        $previous = $this->getPrevious();

        if ($previous instanceof $this)
        {
            return $previous->isNotFound();
        }

        if ($previous instanceof ClientException)
        {
            return $previous->getResponse()->getStatusCode() == 404;
        }

        return false;
    }
}