<?php

namespace NBN\LoadBalancer;

use NBN\LoadBalancer\Exception\HostRequestException;
use NBN\LoadBalancer\Exception\NoAvailableHostException;
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
    public function testHandleRequestNoRegisteredHostException()
    {
        $chooser  = $this->prophesize('NBN\LoadBalancer\Chooser\ChooserInterface');
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request');

        $loadBalancer = new LoadBalancer([], $chooser->reveal());

        $this->expectException(NoRegisteredHostException::class);
        $loadBalancer->handleRequest($request->reveal());
    }

    /**
     * @test LoadBalancer::handleRequest()
     */
    public function testHandleRequestNoAvailableException()
    {
        $chooser  = $this->prophesize('NBN\LoadBalancer\Chooser\ChooserInterface');
        $host     = $this->prophesize('NBN\LoadBalancer\Host\HostInterface');
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request');

        $loadBalancer = new LoadBalancer([$host], $chooser->reveal());

        $this->expectException(NoAvailableHostException::class);
        $loadBalancer->handleRequest($request->reveal());
    }

    /**
     * @test LoadBalancer::handleRequest()
     */
    public function testHandleRequestHostRequestException()
    {
        $host     = $this->prophesize('NBN\LoadBalancer\Host\HostInterface')->reveal();
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request');
        $chooser  = $this->prophesize('NBN\LoadBalancer\Chooser\ChooserInterface');
        $chooser->getAvailableHost($request, [$host])->willReturn($host);

        $loadBalancer = new LoadBalancer([$host], $chooser->reveal());

        $this->expectException(HostRequestException::class);
        $loadBalancer->handleRequest($request->reveal());
    }
}
