<?php

namespace NBN\LoadBalancer;

use NBN\LoadBalancer\Chooser\ChooserInterface;
use NBN\LoadBalancer\Exception\AlreadyRegisteredHostException;
use NBN\LoadBalancer\Exception\HostRequestException;
use NBN\LoadBalancer\Exception\NoAvailableHostException;
use NBN\LoadBalancer\Exception\NoRegisteredHostException;
use NBN\LoadBalancer\Host\Host;
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
        foreach ($hosts as $host) {
            $this->hosts[$host->getId()] = $host;
        }

        $this->chooser = $chooser;
    }

    /**
     * @param HostInterface $host
     */
    public function addHost(HostInterface $host)
    {
        if (isset($this->hosts[$host->getId()])) {
            throw new AlreadyRegisteredHostException();
        }

        $this->hosts[$host->getId()] = $host;
    }

    /**
     * @param string $id
     * @param string $url
     * @param array  $settings
     */
    public function addHostByConfiguration($id, $url, $settings)
    {
        if (isset($this->hosts[$id])) {
            throw new AlreadyRegisteredHostException();
        }

        $this->hosts[$id] = new Host($id, $url, $settings);
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(Request $request)
    {
        if (count($this->hosts) == 0) {
            throw new NoRegisteredHostException();
        }

        $host = $this->chooser->getAvailableHost($request, $this->hosts);
        if ($host == null) {
            throw new NoAvailableHostException();
        }

        $response = $host->handleRequest($request);
        if (!$response instanceof Response) {
            throw new HostRequestException();
        }

        $response->headers->set('Handled-By', $host->getId());

        return $response;
    }
}
