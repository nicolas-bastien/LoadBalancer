<?php

namespace NBN\LoadBalancer\Chooser;

use NBN\LoadBalancer\Host\HostInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
interface ChooserInterface
{
    /**
     * @param  Request  $request
     * @param  array    $hosts
     * @return HostInterface
     */
    public function getAvailableHost(Request $request, array $hosts);
}
