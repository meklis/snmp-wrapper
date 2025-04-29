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
     * 
     */
    public function setOidIncreasingCheck(bool $oid_increasing_check);

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
     * @param $timeoutSec
     * @param $repeats
     * @return PoollerResponse[]
     */
    function walkNext(array $oids, $timeoutSec = null, $repeats = null, $walkNextSleep = 0);

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
