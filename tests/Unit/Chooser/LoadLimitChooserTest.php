<?php

namespace NBN\LoadBalancer\Chooser;

use NBN\LoadBalancer\Exception\NoRegisteredHostException;

/**
 * vendor/bin/phpunit tests/Unit/Chooser/LoadLimitChooserTest.php
 *
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class LoadLimitChooserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test LoadLimitChooser::getAvailableHost()
     */
    public function testGetAvailableHostNoRegisteredHostException()
    {
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request');
        $chooser = new LoadLimitChooser(0.75);

        $this->expectException(NoRegisteredHostException::class);
        $chooser->getAvailableHost($request->reveal(), []);
    }

    /**
     * @test LoadLimitChooser::getAvailableHost()
     */
    public function testGetAvailableHostBadMethodCallException()
    {
        $this->expectException(\BadMethodCallException::class);
        $chooser = new LoadLimitChooser(7.5);
    }

    /**
     * @test LoadLimitChooser::getAvailableHost()
     */
    public function testGetAvailableHost()
    {
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request')->reveal();

        $host1 = $this->prophesize('NBN\LoadBalancer\Host\HostInterface');
        $host1->getId()->willReturn('host-1');
        $host1->getLoad()->willReturn(0.5);
        $host1 = $host1->reveal();
        $host2 = $this->prophesize('NBN\LoadBalancer\Host\HostInterface');
        $host2->getId()->willReturn('host-2');
        $host2->getLoad()->willReturn(0.5);
        $host2 = $host2->reveal();
        $host3 = $this->prophesize('NBN\LoadBalancer\Host\HostInterface');
        $host3->getId()->willReturn('host-3');
        $host3->getLoad()->willReturn(0.5);
        $host3 = $host3->reveal();

        $chooser = new LoadLimitChooser(0.75);
        $host = $chooser->getAvailableHost($request, [$host1, $host2, $host3]);
        $this->assertEquals('host-1', $host->getId());

    }

    /**
     * @test LoadLimitChooser::getAvailableHost()
     */
    public function testGetAvailableHostOutOfLimit()
    {
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request')->reveal();

        $host1 = $this->prophesize('NBN\LoadBalancer\Host\HostInterface');
        $host1->getId()->willReturn('host-1');
        $host1->getLoad()->willReturn(0.35);
        $host1 = $host1->reveal();
        $host2 = $this->prophesize('NBN\LoadBalancer\Host\HostInterface');
        $host2->getId()->willReturn('host-2');
        $host2->getLoad()->willReturn(0.25);
        $host2 = $host2->reveal();
        $host3 = $this->prophesize('NBN\LoadBalancer\Host\HostInterface');
        $host3->getId()->willReturn('host-3');
        $host3->getLoad()->willReturn(0.56);
        $host3 = $host3->reveal();

        $chooser = new LoadLimitChooser(0.2);
        $host = $chooser->getAvailableHost($request, [$host1, $host2, $host3]);
        $this->assertEquals('host-2', $host->getId());
    }
}
