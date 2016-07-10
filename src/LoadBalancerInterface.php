<?php

namespace NBN\LoadBalancer;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
interface LoadBalancerInterface
{
    /**
     * Load balance the request according to loadbalancer configuration
     *
     * @return Response
     */
    public function handleRequest(Request $request);
}
