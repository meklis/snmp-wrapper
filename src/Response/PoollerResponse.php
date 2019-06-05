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
     * @var []SnmpResponse
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
     * @param string $ip
     * @return PoollerResponse
     */
    public function setIp(string $ip): PoollerResponse
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @param string $error
     * @return PoollerResponse
     */
    public function setError(string $error): PoollerResponse
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return string
     */
    public function getOid(): string
    {
        return $this->oid;
    }

    /**
     * @param string $oid
     * @return PoollerResponse
     */
    public function setOid(string $oid): PoollerResponse
    {
        $this->oid = $oid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     * @return PoollerResponse
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFromCache(): bool
    {
        return $this->from_cache;
    }

    /**
     * @param bool $from_cache
     * @return PoollerResponse
     */
    public function setFromCache(bool $from_cache): PoollerResponse
    {
        $this->from_cache = $from_cache;
        return $this;
    }
    /**
     * @var boolean
     */
  protected $from_cache;
}




