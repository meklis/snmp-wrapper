<?php


namespace SnmpWrapper;


class Device
{
    protected $ip;
    protected $pubCommunity;
    protected $privateCommunity;

    protected $version = '2c';

    protected $timeout;
    protected $repeats;
    protected $port = 161;

    public function getArr() {
        return [
            'ip' => $this->ip,
            'pub_community' => $this->pubCommunity,
            'private_community' => $this->privateCommunity,
            'timeout' => $this->timeout,
            'repeats' => $this->repeats,
            'port' => $this->port,
        ];
    }

    protected function __construct(){}

    public static function init($ip, $pubCommunity, $privateCommunity, $timeout = 2, $repeats = 3) {
        $obj = new self();

        return $obj->setIp($ip)->setPubCommunity($pubCommunity)->setPrivateCommunity($privateCommunity)->setTimeout($timeout)->setRepeats($repeats);
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
    public function getPubCommunity()
    {
        return $this->pubCommunity;
    }

    /**
     * @param mixed $pubCommunity
     * @return Device
     */
    protected function setPubCommunity($pubCommunity)
    {
        $this->pubCommunity = $pubCommunity;
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

    /**
     * @return mixed
     */
    public function getPrivateCommunity()
    {
        return $this->privateCommunity;
    }

    /**
     * @param mixed $privateCommunity
     * @return Device
     */
    public function setPrivateCommunity($privateCommunity)
    {
        $this->privateCommunity = $privateCommunity;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return Device
     */
    public function setVersion(string $version): Device
    {
        $this->version = $version;
        return $this;
    }




}