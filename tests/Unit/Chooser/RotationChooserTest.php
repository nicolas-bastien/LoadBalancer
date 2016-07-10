<?php

namespace NBN\LoadBalancer\Chooser;

use NBN\LoadBalancer\Exception\NoRegisteredHostException;
use NBN\LoadBalancer\Host\HostInterface;

/**
 * vendor/bin/phpunit tests/Unit/Chooser/RotationChooserTest.php
 *
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class RotationChooserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test RotationChooser::getAvailableHost()
     */
    public function testGetAvailableHostNoRegisteredHostException()
    {
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request');
        $chooser = new RotationChooser();

        $this->expectException(NoRegisteredHostException::class);
        $chooser->getAvailableHost($request->reveal(), []);
    }

    /**
     * @test RotationChooser::getAvailableHost()
     */
    public function testGetAvailableHost()
    {
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request')->reveal();

        $host1 = $this->prophesize('NBN\LoadBalancer\Host\HostInterface');
        $host1->getId()->willReturn('host-1');
        $host1 = $host1->reveal();
        $host2 = $this->prophesize('NBN\LoadBalancer\Host\HostInterface');
        $host2->getId()->willReturn('host-2');
        $host2 = $host2->reveal();
        $host3 = $this->prophesize('NBN\LoadBalancer\Host\HostInterface');
        $host3->getId()->willReturn('host-3');
        $host3 = $host3->reveal();

        $chooser = new RotationChooser();
        $results = [];

        for ($i=0; $i<10; $i++) {
            $host = $chooser->getAvailableHost($request, [$host1, $host2, $host3]);
            $this->assertTrue($host instanceof HostInterface);
            $results[$host->getId()] = $host;
        }

        //Verify there is more than one result
        $this->assertTrue(count($results) > 1);
    }
}
