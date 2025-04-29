<?php


namespace SnmpWrapper\SnmpT;


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
     * @return string[]
     */
    private function getOidFromObjs(array $oids) {
        $ois = [];
        foreach ($oids as $oid) {
            $ois[] = $oid->getOid();
        }
        return $ois;
    }

    public function setOidIncreasingCheck(bool $oid_increasing_check) {
        throw new \Exception('setOidIncreasingCheck() not implemented in SnmpT/MultiWalker.php');
    }

    /**
     * @param Oid[] $oids
     * @return PoollerResponse[]
     */
    function walk(array $oids, $timeoutSec = null, $repeats = null)
    {
        $response = [];
        foreach ($this->devices as $device) {
            $timeout = $timeoutSec !== null ? $timeoutSec : $device->getTimeout();
            $countRepeats = $repeats !== null ? $repeats : $device->getRepeats();
            $oidResponses = (new SnmpT($device->getIp(), $device->getPubCommunity(), $timeout , $countRepeats))->multiWalk($this->getOidFromObjs($oids));
            foreach ($oidResponses as $data) {
                $pooller = PoollerResponse::init($device->getIp(), $data['oid'], null, $data['error']);
                if (!$data['error']) {
                    $snmpResponses = [];
                    foreach ($data['response'] as $resp) {
                        $snmpResponses[] = SnmpResponse::init($resp['oid'], $resp['type'], $resp['value'], $resp['hex_value']);
                    }
                    $pooller->setResponse($snmpResponses);
                }
                $response[] = $pooller;
            }
        }
        return $response;
    }

    function walkBulk(array $oids, $timeoutSec = null, $repeats = null)
    {
        return $this->walk($oids, $timeoutSec, $repeats);
    }

    function get(array $oids, $timeoutSec = null, $repeats = null)
    {
        $response = [];
        foreach ($this->devices as $device) {
            $timeout = $timeoutSec !== null ? $timeoutSec : $device->getTimeout();
            $countRepeats = $repeats !== null ? $repeats : $device->getRepeats();
            $oidResponses = (new SnmpT($device->getIp(), $device->getPubCommunity(), $timeout  , $countRepeats))->multiGet($this->getOidFromObjs($oids));

            foreach ($oidResponses as $data) {
                if(!$data['oid'] ) $data['oid'] = $data['_oid'];
                $pooller = PoollerResponse::init($device->getIp(), $data['oid'], null, $data['error']);
                if (!$data['error']) {
                    $pooller->setResponse([SnmpResponse::init($data['oid'], $data['type'], $data['value'], $data['hex_value'])]);
                }
                $response[] = $pooller;
            }
        }
        return $response;
    }

    function set(Oid $oid, $timeoutSec = null, $repeats = null)
    {
        $response = [];
        foreach ($this->devices as $device) {
            try {
                $timeout = $timeoutSec !== null ? $timeoutSec : $device->getTimeout();
                $countRepeats = $repeats !== null ? $repeats : $device->getRepeats();
                $type = null;
                switch($oid->getType()) {
                    case 'Integer': $type = SnmpT::SET_TYPE_INTEGER; break;
                    default: $type = SnmpT::SET_TYPE_STRING;
                }
                (new SnmpT($device->getIp(), $device->getPrivateCommunity(), $timeout, $countRepeats))
                    ->set($oid->getOid(), $type, $oid->getValue());
                $response[] = PoollerResponse::init($device->getIp(), $oid->getOid(), [SnmpResponse::init(
                    $oid->getOid(),
                    $oid->getType(),
                    $oid->getValue(),
                    null,
                )]);
            } catch (\Exception $e) {
                $response[] = PoollerResponse::init($device->getIp(), $oid->getOid(), null, $e->getMessage());
            }
        }
        return $response;
    }

    function walkNext(array $oids, $timeoutSec = null, $repeats = null, $walkNextSleep = 0)
    {
        $response = [];
        foreach ($this->devices as $device) {
            $timeout = $timeoutSec !== null ? $timeoutSec : $device->getTimeout();
            $countRepeats = $repeats !== null ? $repeats : $device->getRepeats();
            $oidResponses = (new SnmpT($device->getIp(), $device->getPubCommunity(), $timeout , $countRepeats))->multiWalk($this->getOidFromObjs($oids));
            foreach ($oidResponses as $data) {
                $pooller = PoollerResponse::init($device->getIp(), $data['oid'], null, $data['error']);
                if (!$data['error']) {
                    $snmpResponses = [];
                    foreach ($data['response'] as $resp) {
                        $snmpResponses[] = SnmpResponse::init($resp['oid'], $resp['type'], $resp['value'], $resp['hex_value']);
                    }
                    $pooller->setResponse($snmpResponses);
                }
                $response[] = $pooller;
            }
        }
        return $response;
    }


}
