<?php
/**
 * Created by PhpStorm.
 * User: Meklis
 * Date: 04.06.2019
 * Time: 17:57
 */
namespace SnmpWrapper\Response;

class PoollerResponse
{
    /**
     * @var string
     */
    public $ip;
    /**
     * @var string
     */
    public $error;
    /**
     * @var string
     */
    public $oid;
    /**
     * @var SnmpResponse[]
     */
    public $response;

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @return string | null
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * @return string
     */
    public function getOid(): string
    {
        return $this->oid;
    }


    /**
     * @return SnmpResponse[]
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param array $response
     */
    public function setResponse(array $response)
    {
        $this->response = $response;
        return $this;
    }

    public static function init($deviceIp, $oid, $response = null, ?string $error = null) {
        $obj = new self();
        $obj->ip = $deviceIp;
        $obj->oid = $oid;
        $obj->error = $error;
        $obj->response = $response;
        return $obj;
    }

    /**
     * @return bool
     */
    public function isFromCache(): bool
    {
        return $this->from_cache;
    }

    /**
     * @var boolean
     */
     public $from_cache;
}




