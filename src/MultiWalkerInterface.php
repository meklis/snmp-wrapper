<?php


namespace SnmpWrapper;


use SnmpWrapper\Response\PoollerResponse;

interface MultiWalkerInterface
{

    /**
     * @param Device $device
     * @return self
     */
    function addDevice(Device $device);

    /**
     * @param Device[] $devices
     * @return self
     */
    function addDevices(array $devices);

    /**
     * @return self
     */
    function flushDevices();

    /**
     * @param Oid[] $oids
     * @return PoollerResponse[]
     */
    function walk(array $oids, $timeoutSec = null, $repeats = null);

    /**
     * @param Oid[] $oids
     * @return PoollerResponse[]
     */
    function walkBulk(array $oids, $timeoutSec = null, $repeats = null);

    /**
     * @param Oid[] $oids
     * @return PoollerResponse[]
     */
    function get(array $oids, $timeoutSec = null, $repeats = null);

    /**
     * @param Oid $oid
     * @return PoollerResponse[]
     */
    function set(Oid $oid, $timeoutSec = null, $repeats = null);
}