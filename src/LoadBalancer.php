<?php

namespace NBN\LoadBalancer;

use NBN\LoadBalancer\Chooser\ChooserInterface;
use NBN\LoadBalancer\Exception\NoAvailableHostException;
use NBN\LoadBalancer\Exception\NoRegisterdHostException;
use NBN\LoadBalancer\Exception\NoRegisteredHostException;
use NBN\LoadBalancer\Host\HostInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class LoadBalancer implements LoadBalancerInterface
{
    /**
     * @var array|HostInterface[]
     */
    protected $hosts;

    /**
     * @var ChooserInterface
     */
    protected $chooser;

    /**
     * @param array|HostInterface[] $hosts
     * @param ChooserInterface      $chooser
     */
    public function __construct(array $hosts, ChooserInterface $chooser)
    {
        $this->hosts   = $hosts;
        $this->chooser = $chooser;
    }

    public function addHost(HostInterface $host)
    {
        $this->hosts[] = $host;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(Request $request)
    {
        if (count($this->hosts) == 0) {
            throw new NoRegisteredHostException();
        }

    }
}
