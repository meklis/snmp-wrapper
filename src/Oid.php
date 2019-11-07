<?php


namespace SnmpWrapper;


class Oid
{
    protected $oid;
    protected $use_cache = false;
    protected $type;
    protected $value;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Oid
     */
    public function setType($type)
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
     * @return Oid
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOid()
    {
        return $this->oid;
    }

    /**
     * @param mixed $oid
     * @return Oid
     */
    public function setOid($oid)
    {
        $this->oid = $oid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUseCache()
    {
        return $this->use_cache;
    }

    /**
     * @param mixed $use_cache
     * @return Oid
     */
    public function setUseCache($use_cache)
    {
        $this->use_cache = $use_cache;
        return $this;
    }

}