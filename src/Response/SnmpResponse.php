<?php
/**
 * Created by PhpStorm.
 * User: Meklis
 * Date: 04.06.2019
 * Time: 20:18
 */
namespace SnmpWrapper\Response;


class SnmpResponse
{
    /**
     * @var string
     */
    public $oid;
    /**
     * @var string
     */
    public $hex_value;
    /**
     * @var string
     */
    public $value;

    /**
     * @return string
     */
    public function getOid(): string
    {
        return $this->oid;
    }

    /**
     * @param string $oid
     * @return SnmpResponse
     */
    public function setOid(string $oid): SnmpResponse
    {
        $this->oid = $oid;
        return $this;
    }

    /**
     * @return string
     */
    public function getHexValue(): string
    {
        return $this->hex_value;
    }

    /**
     * @param string $hex_value
     * @return SnmpResponse
     */
    public function setHexValue(string $hex_value): SnmpResponse
    {
        $this->hex_value = $hex_value;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return SnmpResponse
     */
    public function setValue(string $value): SnmpResponse
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return SnmpResponse
     */
    public function setType(string $type): SnmpResponse
    {
        $this->type = $type;
        return $this;
    }
    /**
     * @var string
     */
    protected $type;
}
/*
type SnmpResp struct {
	Oid string `json:"oid"`
	HexValue string `json:"hex_value"`
	Value interface{} `json:"value"`
	Type string `json:"type"`
}

 */