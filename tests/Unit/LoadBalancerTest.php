<?php

namespace NBN\LoadBalancer;

use NBN\LoadBalancer\Exception\AlreadyRegisteredHostException;
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
        $host->getId()->willReturn('host-id');
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request');

        $loadBalancer = new LoadBalancer([$host->reveal()], $chooser->reveal());

        $this->expectException(NoAvailableHostException::class);
        $loadBalancer->handleRequest($request->reveal());
    }

    /**
     * @test LoadBalancer::handleRequest()
     */
    public function testHandleRequestHostRequestException()
    {
        $request  = $this->prophesize('Symfony\Component\HttpFoundation\Request')->reveal();
        $host     = $this->prophesize('NBN\LoadBalancer\Host\HostInterface');
        $host->getId()->willReturn('host-id');
        $host->handleRequest($request)->willReturn(null);
        $host     = $host->reveal();
        $chooser  = $this->prophesize('NBN\LoadBalancer\Chooser\ChooserInterface');
        $chooser->getAvailableHost($request, ['host-id' => $host])->willReturn($host);

        $loadBalancer = new LoadBalancer([$host], $chooser->reveal());

        $this->expectException(HostRequestException::class);
        $loadBalancer->handleRequest($request);
    }

    /**
     * @test LoadBalancer::addHostByConfiguration()
     */
    public function testaddHostByConfigurationAlreadyRegisteredHostException()
    {
        $host = $this->prophesize('NBN\LoadBalancer\Host\HostInterface');
        $host->getId()->willReturn('host-id');
        $chooser = $this->prophesize('NBN\LoadBalancer\Chooser\ChooserInterface');

        $loadBalancer = new LoadBalancer([$host->reveal()], $chooser->reveal());

        $this->expectException(AlreadyRegisteredHostException::class);
        $loadBalancer->addHostByConfiguration('host-id', 'url', []);
    }
}
