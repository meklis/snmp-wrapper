<?php


namespace SnmpWrapper\SnmpT;


class SnmpT
{
    const SET_TYPE_INTEGER = 'i';
    const SET_TYPE_STRING = 's';

    protected $path;
    protected $ip;
    protected $community;
    protected $timeoutSec;
    protected $retries;


    /**
     * PhpSnmp constructor.
     * @param string $ip
     * @param string $community
     * @param int|null $timeout
     */
    public function __construct(string $ip, string $community, int $timeout_sec = null, $retries = null)
    {
        $this->path = __DIR__ . '/snmpt';
        $this->ip = $ip;
        $this->community = $community;
        $this->timeoutSec = $timeout_sec;
        $this->retries = $retries;
    }

    /**
     * @param string $oid
     * @return array
     * @throws \Exception
     */
    function walk(string $oid)
    {
        return $this->_exec("walk", $oid);
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
        return $this->_exec("get", $oid)[0];
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
                    'hex_value' => $obj['hex_value'],
                ];
            } catch (\Exception $e) {
                $err = $e;
                $resp[] = [
                    '_oid' => $oid,
                    'oid' => null,
                    'hex_value' => null,
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
        $this->_exec("set", $oid, $type, $value);
        restore_error_handler();
        return $this;
    }



    function _exec($command, $oid, $type = "", $value = "") {
        $output = "";
        $code = 0;
        if($command != "set") {
            $out = exec("{$this->path} -t {$this->timeoutSec} -r {$this->retries} -c {$this->community} {$command} {$this->ip} {$oid}", $output, $code);
        } else {
            $out = exec("{$this->path} -t {$this->timeoutSec} -r {$this->retries} -c {$this->community} {$command} {$this->ip} {$oid} {$type} {$value}", $output, $code);
        }
        if($code != 0) {
            throw new \Exception("SNMP ERROR: " . $out);
        }
        return json_decode(join("\n", $output), true);
    }
}