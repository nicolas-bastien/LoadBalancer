<?php

namespace NBN\LoadBalancer\Host;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
interface HostInterface
{
    /**
     * @return float
     */
    public function getLoad();

    /**
     * @return Response
     */
    public function handleRequest(Request $request);
}
