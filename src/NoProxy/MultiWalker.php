<?php


namespace SnmpWrapper\NoProxy;


use SnmpWrapper\Device;
use SnmpWrapper\MultiWalkerInterface;
use SnmpWrapper\Oid;
use SnmpWrapper\Response\PoollerResponse;
use SnmpWrapper\Response\SnmpResponse;

class MultiWalker implements MultiWalkerInterface
{
    /**
     * @var Device[]
     */
    protected $devices = [];


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
            $oidResponses = (new PhpSnmp($device->getIp(), $device->getCommunity(), $device->getTimeout() * 1000, $device->getRepeats()))->multiWalk($oids);
            foreach ($oidResponses as $data) {
                $pooller = PoollerResponse::init($device->getIp(), $data['oid'], null, $data['error']);
                if (!$data['error']) {
                    $snmpResponses = [];
                    foreach ($data['response'] as $resp) {
                        $snmpResponses[] = SnmpResponse::init($resp['oid'], $resp['type'], $resp['value'], $this->wrapStrToHex($resp['value']));
                    }
                    $pooller->setResponse($snmpResponses);
                }
                $response[] = $pooller;
            }
        }
        return $response;
    }

    private function wrapStrToHex($val)
    {
        $hx = '';
        if(is_numeric($val)) {
            $hx =  strtoupper(dechex($val));
        }
        $hx  = strtoupper(bin2hex($val));
        $result = '';
        $lims = 0;
        foreach (str_split ($hx) as $h) {
            $lims++;
            $result .= $h;
            if($lims >= 2) {
                $result .= ':';
                $lims = 0;
            }
        }
        return trim($result, ':');
    }

    function walkBulk(array $oids)
    {
        return $this->walk($oids);
    }

    function get(array $oids)
    {
        $response = [];
        foreach ($this->devices as $device) {
            $oidResponses = (new PhpSnmp($device->getIp(), $device->getCommunity(), $device->getTimeout() * 1000, $device->getRepeats()))->multiGet($oids);
            foreach ($oidResponses as $data) {
                $pooller = PoollerResponse::init($device->getIp(), $data['oid'], null, $data['error']);
                if (!$data['error']) {
                    $snmpResponses = [];
                    $snmpResponses[] = SnmpResponse::init($data['oid'], $data['type'], $data['value'], $this->wrapStrToHex($data['value']));
                    $pooller->setResponse($snmpResponses);
                }
                $response[] = $pooller;
            }
        }
        return $response;
    }

    function set(Oid $oid)
    {
        $response = [];
        foreach ($this->devices as $device) {
            try {
                (new PhpSnmp($device->getIp(), $device->getCommunity(), $device->getTimeout() * 1000, $device->getRepeats()))->set($oid->getOid(), $oid->getType(), $oid->getValue());
                $response[] = PoollerResponse::init($device->getIp(), $oid->getOid(), SnmpResponse::init(
                    $oid->getOid(),
                    $oid->getType(),
                    $oid->getValue(),
                    $this->wrapStrToHex($oid->getValue())
                ));
            } catch (\Exception $e) {
                $response[] = PoollerResponse::init($device->getIp(), $oid->getOid(), null, $e->getMessage());
            }
        }
        return $response;
    }

}