<?php

namespace NBN\LoadBalancer\Chooser;

use NBN\LoadBalancer\Exception\NoRegisteredHostException;
use NBN\LoadBalancer\Host\HostInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class LoadLimitChooser implements ChooserInterface
{
    /**
     * @var float
     */
    protected $loadLimit;

    /**
     * @param float $loadLimit
     */
    public function __construct($loadLimit)
    {
        if ($loadLimit < 0 || $loadLimit > 1) {
            throw new \BadMethodCallException('Load limit should be between 0 and 1');
        }

        $this->loadLimit = $loadLimit;
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableHost(Request $request, array $hosts)
    {
        if (count($hosts) == 0) {
            throw new NoRegisteredHostException();
        }

        $currentLoad = 1;
        $currentHost = null;

        foreach ($hosts as $host) {
            $load = $host->getLoad();
            if ($load < $this->loadLimit) {
                return $host;
            }
            if ($currentHost == null || $load < $currentLoad) {
                $currentLoad = $load;
                $currentHost = $host;
            }
        }

        return $currentHost;
    }
}
