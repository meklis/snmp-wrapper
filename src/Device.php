<?php


namespace SnmpWrapper;


class Device
{
    protected $ip;
    protected $community;
    protected $timeout;
    protected $repeats;
    protected $port;

    public function getArr() {
        return [
            'ip' => $this->ip,
            'community' => $this->community,
            'timeout' => $this->timeout,
            'repeats' => $this->repeats,
            'port' => $this->port,
        ];
    }

    protected function __construct(){}

    public static function init($ip, $community, $timeout = 2, $repeats = 3, $port = 161) {
        $obj = new self();
        if(!$port) {
            $port = 161;
        }
        return $obj->setIp($ip)->setCommunity($community)->setTimeout($timeout)->setRepeats($repeats)->setPort($port);
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     * @return Device
     */
    protected function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommunity()
    {
        return $this->community;
    }

    /**
     * @param mixed $community
     * @return Device
     */
    protected function setCommunity($community)
    {
        $this->community = $community;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param mixed $timeout
     * @return Device
     */
    protected function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRepeats()
    {
        return $this->repeats;
    }

    /**
     * @param mixed $repeats
     * @return Device
     */
    protected function setRepeats($repeats)
    {
        $this->repeats = $repeats;
        return $this;
    }

    function setPort($port) {
        $this->port = $port;
        return $this;
    }

    function getPort() {
        return $this->port;
    }


}