<?php namespace LicenseJet\Endpoint;

use LicenseJet\LicenseJetException;
use LicenseJet\Resource\LicensingPlan;
use LicenseJet\Collection\LicensingPlanCollection;
use LicenseJet\RequestBuilder\CollectionRequestBuilder;

/**
 * The Licensing Plan Endpoint.
 * 
 * Class LicensingPlanEndpoint
 * @package LicenseJet\Endpoint
 */
Class LicensingPlanEndpoint extends Endpoint
{
    /**
     * Retrieve the licensing plans.
     *
     * @return CollectionRequestBuilder
     */
    public function list() {
        return new CollectionRequestBuilder(
            $this->identity,
            $this,
            'licensing_plans',
            function ($project)
            {
                return new LicensingPlan((array) $project);
            },
            new LicensingPlanCollection()
        );
    }

    /**
     * Retrieve the licensing plan by ID.
     *
     * @param $licensingPlanId
     * @return LicensingPlan
     * @throws LicenseJetException
     */
    public function get(int $licensingPlanId) : LicensingPlan
    {
        $response = $this->request('GET', 'licensing_plans/'.$licensingPlanId, []);

        if ($response->isSuccessful())
        {
            return LicensingPlan::createFromArray((array) $response->getPayload());
        }

        throw new LicenseJetException('Failed to update resource. Error: '.$response->getErrorMessage());
    }

    /**
     * Update a licensing plan.
     *
     * @param LicensingPlan $licensingPlan
     * @return LicensingPlan
     * @throws LicenseJetException
     */
    public function update(LicensingPlan $licensingPlan) : LicensingPlan
    {
        $response = $this->request(
            'POST',
            'licensing_plans/'.$licensingPlan->getId(),
            $licensingPlan->toArray()
        );

        if ($response->isSuccessful())
        {
            return LicensingPlan::createFromArray((array) $response->getPayload());
        }

        throw new LicenseJetException('Failed to update resource. Error: '.$response->getErrorMessage());
    }
}