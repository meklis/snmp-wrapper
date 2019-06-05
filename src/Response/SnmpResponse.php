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
     * @var string
     */
    public $type;

    /**
     * @return string
     */
    public function getOid(): string
    {
        return $this->oid;
    }


    /**
     * @return string
     */
    public function getHexValue(): string
    {
        return $this->hex_value;
    }


    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }


    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

}
/*
type SnmpResp struct {
	Oid string `json:"oid"`
	HexValue string `json:"hex_value"`
	Value interface{} `json:"value"`
	Type string `json:"type"`
}

 */