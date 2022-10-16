<?php

namespace App\Service;

use Exception;
use Illuminate\Support\Collection;

/**
 * This class is used to open read and parse the hosts file
 */
class HostManager
{
    const DEV_HOSTS_PATH = 'data/hosts';
    const DEFAULT_HOSTS_PATH = '/etc/ansible/hosts';

    /**
     * @var string|false
     */
    protected string $filePath;
    /**
     * @var Collection
     */
    protected Collection $lines;

    /**
     * @param string $filePath
     * @throws Exception
     */
    public function __construct($filePath = null)
    {
        if (is_null($filePath)) {
            $filePath = self::DEFAULT_HOSTS_PATH;
        }

        if (!is_file($filePath) || !is_readable($filePath)) {
            throw new Exception(sprintf('Unable to read file: %s', $filePath));
        }

        $this->filePath = realpath($filePath);
    }

    /**
     * @param string $host
     * @return array
     */
    public function getIps(string $host): array {

        if ($host == 'all') {
            return $this->getAllHostIps();
        }

        return $this->getHostIps($host);
    }

    /**
     * @param $host
     * @return array
     */
    protected function getHostIps($host): array
    {
        $file = fopen($this->filePath, 'r');

        while (($line = fgets($file)) !== false) {
            if (trim($line) == sprintf("[%s]", $host)) {
                $ipsLine = fgets($file);
                fclose($file);
                return $this->parseIps($ipsLine);
            }
        }

        fclose($file);
        return [];
    }

    /**
     * @param string $line
     * @return bool
     */
    protected function isIpsLine(string $line): bool
    {
        return 0 < strlen($line) && is_numeric($line[0]);
    }

    /**
     * @return array
     */
    protected function getAllHostIps(): array
    {
        $ips = [];
        $file = fopen($this->filePath, 'r');

        while (($line = fgets($file)) !== false) {
            if ($this->isIpsLine($line)) {
                $ips = array_merge($ips, $this->parseIps($line));
            }
        }

        fclose($file);
        return $ips;
    }

    /**
     * @param $str
     * @return array
     */
    protected function parseIps($str): array
    {
        $ips = explode(',', $str);
        foreach ($ips as $index => $ip) {
            $ips[$index] = trim($ip);
        }

        return $ips;
    }
}