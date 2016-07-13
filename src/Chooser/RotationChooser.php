<?php

namespace NBN\LoadBalancer\Chooser;

use NBN\LoadBalancer\Exception\NoRegisteredHostException;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class RotationChooser implements ChooserInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAvailableHost(Request $request, array $hosts)
    {
        if (count($hosts) == 0) {
            throw new NoRegisteredHostException();
        }

        //basic random
        return $hosts[array_rand($hosts)];
    }
}
