<?php

namespace NBN\LoadBalancer\Host;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class Host implements HostInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @param string $id
     * @param string $url
     * @param array  $settings
     */
    public function __construct($id, $url, array $settings)
    {
        $this->id = $id;
        $this->url = $url;
        $this->settings = $settings;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritdoc}
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param  string $name     Setting name
     * @param  mixed  $default  Default value is setting is not set
     * @return mixed
     */
    public function getSetting($name, $default = null)
    {
        if (isset($this->settings[$name])) {
            return $this->settings[$name];
        }

        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function getLoad()
    {
        //if load is not defined presume it's overloaded
        return $this->getSetting('load', 1);
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(Request $request)
    {
        $response = new Response();
        $response->setStatusCode($this->getSetting('response-status', 200));
        $response->setContent(sprintf($this->getSetting('response-content-format', '%s'), $request->getUri()));

        return $response;
    }
}
