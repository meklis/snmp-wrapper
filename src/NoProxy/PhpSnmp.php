<?php


namespace SnmpWrapper\NoProxy;


class PhpSnmp implements SnmpInterface
{
    protected $snmp;
    protected $types = [
        2 => 'INTEGER',
    ];
    const SET_TYPE_INTEGER = 'i';
    const SET_TYPE_STRING = 's';

    /**
     * PhpSnmp constructor.
     * @param string $ip
     * @param string $community
     * @param int|null $timeout
     */
    public function __construct(string $ip, string $community, int $timeout_ms = null, $retries = null)
    {
        if (!$timeout_ms) {
            $timeout_ms = -1;
        } else {
            $timeout_ms *= 1000;
        }
        if (!$retries) {
            $retries = -1;
        }
        $snmp = new \SNMP(\SNMP::VERSION_2C, $ip, $community, $timeout_ms, $retries);
        $snmp->oid_output_format = SNMP_OID_OUTPUT_NUMERIC;
        $snmp->quick_print = true;
        $snmp->oid_increasing_check = false;
        $snmp->valueretrieval = SNMP_VALUE_OBJECT;
        $this->snmp = $snmp;
    }

    /**
     * @param string $oid
     * @return array
     * @throws \Exception
     */
    function walk(string $oid)
    {
        $response = [];
        $objs = @$this->snmp->walk($oid);
        if (!$objs) {
            throw new \Exception($this->snmp->getError(), $this->snmp->getErrno());
        }
        foreach ($objs as $oid => $obj) {
            $response[] = [
                'oid' => $oid,
                'type' => $this->types[$obj->type],
                'value' => $obj->value,
            ];
        }
        return $response;
    }

    /**
     * @param array $oids
     * @return array
     */
    function multiWalk(array $oids)
    {
        $resp = [];
        foreach ($oids as $oid) {
            $response = null;
            $err = null;
            try {
                $response = $this->walk($oid);
            } catch (\Exception $e) {
                $err = $e;
            }
            $resp[] = [
                'oid' => $oid,
                'response' => $response,
                'error' => $err,
            ];
        }
        return $resp;
    }


    /**
     * @param string $oid
     * @return array
     * @throws \Exception
     */
    function get(string $oid)
    {
        $obj = @$this->snmp->get($oid);
        if (!$obj) {
            throw new \Exception($this->snmp->getError(), $this->snmp->getErrno());
        }
        return [
            'oid' => $oid,
            'type' => $this->types[$obj->type],
            'value' => $obj->value,
        ];
    }

    /**
     * @param array $oids
     * @return array
     * @throws \Exception
     */
    function multiGet(array $oids)
    {

        $resp = [];
        foreach ($oids as $oid) {
            $response = null;
            $err = null;
            try {
                $obj = $this->get($oid);
            } catch (\Exception $e) {
                $err = $e;
            }
            $resp[] = [
                'oid' => $oid,
                'type' => $this->types[$obj['type']],
                'value' => $obj['value'],
                'error' => $err,
            ];
        }
        return $resp;

    }

    /**
     * @param string $oid
     * @param string $type
     * @param $value
     * @return $this
     * @throws \Exception
     */
    function set(string $oid, string $type, $value)
    {
       if(!@$this->snmp->set($oid, $type, $value)) {
           throw new \Exception($this->snmp->getError(), $this->snmp->getErrno());
       }
       return $this;
    }

}