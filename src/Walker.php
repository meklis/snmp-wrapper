<?php
/**
 * Created by PhpStorm.
 * User: Meklis
 * Date: 04.06.2019
 * Time: 22:07
 */

namespace SnmpWrapper;


use SnmpWrapper\Request\PoollerRequest;

class Walker
{
    protected $wrapper = null;
    protected $ip = "";
    protected $community = "";
    protected $enableCache = false;
    protected $repeats = 2;
    protected $timeoutSec = 3;
    /**
     * Walker constructor.
     * @param WrapperWorker $wrapper
     */


    function __construct(WrapperWorker $wrapper)
    {
        $this->wrapper = $wrapper;
    }

    /**
     * @return bool
     */
    function getCacheStatus() {
        return $this->enableCache;
    }
    /**
     * @param $ip
     * @return $this
     */
    function setIp($ip) {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @param $enable
     * @return $this
     */
    function useCache($enable) {
        $this->enableCache = $enable;
        return $this;
    }

    /**
     * @param $countRepeats
     * @return $this
     */
    function setRepeats($countRepeats) {
        $this->repeats = $countRepeats;
        return $this;
    }

    /**
     * @param $timeoutSec
     * @return $this
     */
    function setTimeout($timeoutSec) {
        $this->timeoutSec = $timeoutSec;
        return $this;
    }

    /**
     * @param $community
     * @return $this
     */
    function setCommunity($community) {
        $this->community = $community;
        return $this;
    }
    private function formatRequest($oids) {
        $request = [];
        foreach ($oids as $oid) {
            $request[] = (new Request\PoollerRequest())
                ->setOid($oid)
                ->setCommunity($this->community)
                ->setUseCache($this->enableCache)
                ->setIp($this->ip)
                ->setTimeout($this->timeoutSec)
                ->setRepeats($this->repeats);
        }
        return $request;
    }

    /**
     * @param string[] $oids
     * @return Response\PoollerResponse[]
     */
    function walk($oids) {
        return $this->wrapper->walk($this->formatRequest($oids));
    }

    /**
     * @param string[] $oids
     * @return Response\PoollerResponse[]
     */
    function walkBulk($oids) {
        return $this->wrapper->walkBulk($this->formatRequest($oids));
    }

    /**
     * @param string[] $oids
     * @return Response\PoollerResponse[]
     */
    function get($oids) {
        return $this->wrapper->get($this->formatRequest($oids));
    }

    /**
     * @param string $oid
     * @param Request\PoollerRequest::TypeOctetStringValue|Request\PoollerRequest::TypeIntegerValue  $type
     * @param string|integer $value
     * @return Response\PoollerResponse[]
     */
    function set($oid, $type, $value) {
        $req = (new Request\PoollerRequest())
            ->setOid($oid)
            ->setUseCache($this->enableCache)
            ->setCommunity($this->community)
            ->setIp($this->ip)
            ->setTimeout($this->timeoutSec)
            ->setRepeats($this->repeats)
            ->setType($type)
            ->setValue($value);
        return $this->wrapper->set([$req]);
    }
}