<?php

namespace NBN\LoadBalancer\Chooser;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
interface ChooserInterface
{
    /**
     * @param  Request  $request
     * @param  array    $hosts
     * @return Response
     */
    public function handleRequest(Request $request, array $hosts);
}
