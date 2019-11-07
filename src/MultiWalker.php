<?php
/**
 * Created by PhpStorm.
 * User: Meklis
 * Date: 04.06.2019
 * Time: 22:07
 */

namespace SnmpWrapper;



class MultiWalker
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
     * @return Response\PoollerResponse[]
     */
    function walk($oids) {
        return $this->wrapper->walk($this->formatRequest($oids));
    }

    /**
     * @param Oid[] $oids
     * @return Response\PoollerResponse[]
     */
    function walkBulk($oids) {
        return $this->wrapper->walkBulk($this->formatRequest($oids));
    }

    /**
     * @param Oid[] $oids
     * @return Response\PoollerResponse[]
     */
    function get($oids) {
        return $this->wrapper->get($this->formatRequest($oids));
    }

    /**
     * @param Oid $oid
     * @param Request\PoollerRequest::TypeOctetStringValue|Request\PoollerRequest::TypeIntegerValue  $type
     * @param string|integer $value
     * @return Response\PoollerResponse[]
     */
    function set(Oid $oid) {
        $req = [];
        foreach ($this->devices as $dev) {
            $req[] = (new Request\PoollerRequest())
                ->setOid($oid->getOid())
                ->setUseCache($oid->getUseCache())
                ->setCommunity($dev->getCommunity())
                ->setIp($dev->getIp())
                ->setTimeout($dev->getTimeout())
                ->setRepeats($dev->getRepeats())
                ->setType($oid->getValue())
                ->setValue($oid->getValue());
        }
        return $this->wrapper->set($req);
    }
}