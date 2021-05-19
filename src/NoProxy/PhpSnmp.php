<?php


namespace SnmpWrapper\NoProxy;


class PhpSnmp implements SnmpInterface
{
    protected $snmp;
    protected $types = [
        2 => 'Integer',
        4 => 'String',
        6 => 'OID',
        65 => 'Integer',
        66 => 'Integer',
        67 => 'Timeticks',
        70 => 'Counters64',
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
        $snmp->exceptions_enabled = \SNMP::ERRNO_ANY;
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
            if($obj->type == 67) {
                $obj->value  = $this->parseTimeTicks($obj->value);
            }
            $response[] = [
                'oid' => $oid,
                'type' => $this->types[$obj->type],
                'value' => trim($obj->value, '"'),
            ];
        }
        return $response;
    }
    private function parseTimeTicks($timetick) {

        $data = explode(":", $timetick);
        return
            //Дни
              (($data[0] * 24 * 60 * 60) +
                //Часы
                ($data[1] * 60 * 60) +
                //Минуты
                ($data[2] * 60) +
                //Секунды
                ((int)$data[3]) );
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

        if($obj->type == 67) {
            $obj->value  = $this->parseTimeTicks($obj->value);
        }
        return [
            'oid' => $oid,
            'type' => $this->types[$obj->type],
            'value' => trim($obj->value, '"'),
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
                $resp[] = [
                    '_oid' => $obj['oid'],
                    'oid' => $obj['oid'],
                    'type' => $obj['type'],
                    'value' => $obj['value'],
                    'error' => $err,
                ];
            } catch (\Exception $e) {
                $err = $e;
                $resp[] = [
                    '_oid' => $oid,
                    'oid' => null,
                    'type' => null ,
                    'value' => null,
                    'error' => $err,
                ];
            }


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
        set_error_handler(function($errno, $errstr, $errfile, $errline, $errcontext) {
            // error was suppressed with the @-operator
            if (0 === error_reporting()) {
                return false;
            }
            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
        $this->snmp->set($oid, $type, $value);
        restore_error_handler();
        return $this;
    }

}
