<?php


namespace SnmpWrapper;


class Device
{
    protected $ip;
    protected $community;
    protected $timeout;
    protected $repeats;

    public function getArr() {
        return [
            'ip' => $this->ip,
            'community' => $this->community,
            'timeout' => $this->timeout,
            'repeats' => $this->repeats,
        ];
    }

    protected function __construct(){}

    public static function init($ip, $community, $timeout = 2, $repeats = 3) {
        $obj = new self();
        return $obj->setIp($ip)->setCommunity($community)->setTimeout($timeout)->setRepeats($repeats);
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


}