<?php

namespace NBN\LoadBalancer\Chooser;

use Symfony\Component\HttpFoundation\Request;

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
    public function getAvailableHost(Request $request, array $hosts);
}
