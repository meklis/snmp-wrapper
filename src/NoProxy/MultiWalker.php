<?php


namespace SnmpWrapper\NoProxy;


use SnmpWrapper\Device;
use SnmpWrapper\MultiWalkerInterface;
use SnmpWrapper\Oid;
use SnmpWrapper\Response\PoollerResponse;

class MultiWalker implements MultiWalkerInterface
{
    /**
     * @var Device[]
     */
    protected $devices;

    function addDevice(Device $device)
    {
        $this->devices[] = $device;
        return $this;
    }


    function addDevices(array $devices)
    {
        $this->devices = array_merge($this->devices, $devices);
        return $this;
    }

    function flushDevices()
    {
       $this->devices = [];
    }

    /**
     * @param Oid[] $oids
     * @return PoollerResponse[]
     */
    function walk(array $oids)
    {
        $response = [];
        foreach ($this->devices as $device) {
            foreach ($oids as $oid) {

            }
        }
    }

    function walkBulk(array $oids)
    {
        // TODO: Implement walkBulk() method.
    }

    function get(array $oids)
    {
        // TODO: Implement get() method.
    }

    function set(Oid $oid)
    {
        // TODO: Implement set() method.
    }

}