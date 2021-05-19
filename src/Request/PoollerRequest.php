<?php
/**
 * Created by PhpStorm.
 * User: Meklis
 * Date: 04.06.2019
 * Time: 17:24
 */
namespace SnmpWrapper\Request;


class PoollerRequest
{
    const TypeOctetStringValue = "OctetString";
    const TypeIntegerValue = "Integer";
    /**
     * @var string
     */
    public $ip;
    /**
     * @var string
     */
    public $community;
    /**
     * @var string
     */
    public $oid;
    /**
     * @var int
     */
    public $repeats = 2;
    /**
     * @var int
     */
    public  $timeout = 3;
    /**
     * @var PoollerRequest::TypeOctetStringValue | PoollerRequest::TypeIntegerValue
     */
    public $type;
    /**
     * @var mixed
     */
    public $value;
    /**
     * @var boolean
     */
    public $use_cache = true;

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     * @return PoollerRequest
     */
    public function setIp(string $ip): PoollerRequest
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommunity(): string
    {
        return $this->community;
    }

    /**
     * @param string $community
     * @return PoollerRequest
     */
    public function setCommunity(string $community): PoollerRequest
    {
        $this->community = $community;
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
     * @return PoollerRequest
     */
    public function setOid(string $oid): PoollerRequest
    {
        $this->oid = $oid;
        return $this;
    }

    /**
     * @return int
     */
    public function getRepeats(): int
    {
        return $this->repeats;
    }

    /**
     * @param int $repeats
     * @return PoollerRequest
     */
    public function setRepeats(int $repeats): PoollerRequest
    {
        $this->repeats = $repeats;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     * @return PoollerRequest
     */
    public function setTimeout(int $timeout): PoollerRequest
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * @return PoollerRequest
     */
    public function getType(): PoollerRequest
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return PoollerRequest
     */
    public function setType($type): PoollerRequest
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return PoollerRequest
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUseCache(): bool
    {
        return $this->use_cache;
    }

    /**
     * @param bool $use_cache
     * @return PoollerRequest
     */
    public function setUseCache(bool $use_cache): PoollerRequest
    {
        $this->use_cache = $use_cache;
        return $this;
    }
}

