<?php

namespace NBN\LoadBalancer;

use NBN\LoadBalancer\Exception\NoRegisteredHostException;

/**
 * vendor/bin/phpunit tests/Unit/LoadBalancerTest.php
 *
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class LoadBalancerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test LoadBalancer::handleRequest()
     */
    public function testHandleRequestNoHostException()
    {
        $chooser  = $this->prophesize('NBN\LoadBalancer\Chooser\ChooserInterface');
        $resquest = $this->prophesize('Symfony\Component\HttpFoundation\Request');

        $loadBalancer = new LoadBalancer([], $chooser->reveal());

        $this->expectException(NoRegisteredHostException::class);
        $loadBalancer->handleRequest($resquest->reveal());
    }
}
