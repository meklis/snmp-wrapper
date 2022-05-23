<?php
/**
 * Created by PhpStorm.
 * User: Meklis
 * Date: 04.06.2019
 * Time: 22:07
 */

namespace SnmpWrapper;



use SnmpWrapper\Response\PoollerResponse;

class MultiWalker implements MultiWalkerInterface
{
    /**
     * @var WrapperWorker
     */
    protected $wrapper = null;

    /**
     * @var Device[]
     */
    protected $devices = [];

    /**
     * Walker constructor.
     * @param WrapperWorker $wrapper
     */
    function __construct(WrapperWorker $wrapper)
    {
        $this->wrapper = $wrapper;
    }

    /**
     * Добавляет в список опроса оборудование, нужно передать обьект Device
     * @param Device $device
     * @return self
     */
    public function addDevice(Device $device) {
        $this->devices[] = $device;
        return $this;
    }

    public function flushDevices() {
        $this->devices = [];
        return $this;
    }

    /**
     * @param Device[] $devices
     * @throws \Exception
     */
    public function addDevices(array $devices) {
        foreach ($devices as $dev) {
            if(is_object($dev) && $dev instanceof Device) {
                $this->devices[] = $dev;
            } else {
                throw new \Exception("Device object only allow to adding");
            }
        }
    }


    /**
     * @param Oid[] $oids
     * @return array
     */
    private function formatRequest(array $oids) {
        $request = [];
        foreach ($oids as $oid) {
            foreach ($this->devices as $dev) {
                $request[] = (new Request\PoollerRequest())
                    ->setOid($oid->getOid())
                    ->setCommunity($dev->getCommunity())
                    ->setUseCache($oid->getUseCache())
                    ->setIp($dev->getIp())
                    ->setTimeout($dev->getTimeout())
                    ->setRepeats($dev->getRepeats());
            }
        }
        return $request;
    }

    /**
     * @param Oid[] $oids
     * @return PoollerResponse[]
     */
    function walk(array $oids, $timeoutSec = null, $repeats = null) {
        return $this->wrapper->walk($this->formatRequest($oids), $timeoutSec, $repeats);
    }

    /**
     * @param Oid[] $oids
     * @return Response\PoollerResponse[]
     */
    function walkBulk(array $oids, $timeoutSec = null, $repeats = null) {
        return $this->wrapper->walkBulk($this->formatRequest($oids), $timeoutSec, $repeats);
    }

    /**
     * @param Oid[] $oids
     * @return Response\PoollerResponse[]
     */
    function get(array $oids, $timeoutSec = null, $repeats = null) {
        return $this->wrapper->get($this->formatRequest($oids), $timeoutSec, $repeats);
    }

    /**
     * @param Oid $oid
     * @param Request\PoollerRequest::TypeOctetStringValue|Request\PoollerRequest::TypeIntegerValue  $type
     * @param string|integer $value
     * @return Response\PoollerResponse[]
     */
    function set(Oid $oid, $timeoutSec = null, $repeats = null) {
        $req = [];
        foreach ($this->devices as $dev) {
            $req[] = (new Request\PoollerRequest())
                ->setOid($oid->getOid())
                ->setUseCache($oid->getUseCache())
                ->setCommunity($dev->getCommunity())
                ->setIp($dev->getIp())
                ->setTimeout($timeoutSec !== null ? $timeoutSec : $dev->getTimeout())
                ->setRepeats($repeats !== null ? $repeats : $dev->getRepeats())
                ->setType($oid->getType())
                ->setValue($oid->getValue());
        }
        return $this->wrapper->set($req);
    }

    function walkNext(array $oids, $timoutSec = null, $repeats = null)
    {
       return $this->walk($oids, $timoutSec, $repeats);
    }

}