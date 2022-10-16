<?php

namespace App\Service;

/**
 * this class is used to handle header before to run the tasks
 */
class TargetServerManager
{
    /**
     * @var string|mixed
     */
    protected string $name;
    /**
     * @var string|mixed
     */
    protected string $hosts;
    /**
     * @var string
     */
    protected string $user = 'root';

    /**
     * @var HostManager
     */
    protected HostManager $hostManager;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf("%s %s", $this->name, $this->hosts);
    }

    /**
     * @param string $name
     * @param string $hosts
     * @param string $user
     */
    public function __construct(string $name = '', string $hosts = '', string $user = 'root')
    {
        $this->hostManager = new HostManager();
        $this->name = $name;
        $this->hosts = $hosts;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return array
     */
    public function getIps(): array
    {
        return $this->hostManager->getIps($this->hosts);
    }

    /**
     * @return string
     */
    public function getHosts(): string
    {
        return $this->hosts;
    }
}