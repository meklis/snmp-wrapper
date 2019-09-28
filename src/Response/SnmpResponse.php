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
    const HUMANIZE_DURATION = 0;
    const TIMETICS = 1;
    const STARTED = 2;
    /**
     * @var string
     */
    public $oid="";
    /**
     * @var string
     */
    public $hex_value="";
    /**
     * @var string
     */
    public $value ="";

    /**
     * @var string
     */
    public $type ="";

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
     * @param SnmpResponse::HUMANIZE_DURATION|SnmpResponse::TIMETICS|SnmpResponse::STARTED $format
     * @return string
     */
    public function getValueAsTimeTicks($format = 0) {
        $timetrics = $this->value;
        if(!is_numeric($timetrics)) {
            throw new \Exception("'$timetrics' is non-numeric value");
        }
        $days = floor($timetrics/ 8640000   );
        $hours = floor(($timetrics - (8640000    * $days)) / 360000 );
        $minutes = floor(($timetrics - (8640000  * $days) - (360000 * $hours) ) / 6000 );
        $seconds = floor( ($timetrics - (8640000  * $days) - (360000 * $hours)- (6000 * $minutes)) / 100 );
        $started = date("Y-m-d H:i:s", time() - $timetrics/100);
        switch ($format) {
            case self::TIMETICS:  return $timetrics;
            case self::HUMANIZE_DURATION:  return "{$days}d {$hours}h {$minutes}min {$seconds}sec";
            case self::STARTED:  return $started;
            default:
                throw new \InvalidArgumentException("Not supported format. Use TIMETICS|HUMANIZE_DURATION|STARTED");
        }
    }

    /**
     * @return string
     */
    public function getValueAsBinary() {
        $decFull = "";
        foreach(explode(":", $this->hex_value) as $val) {
            $decs = decbin(hexdec($val));
            while(strlen($decs)<8) $decs = "0".$decs;
            $decFull .=$decs;
        }
        return $decFull;
    }

    /**
     * @return string
     */
    public function getOidAsHex() {
        $hex = "";
        foreach (explode(".", $this->oid) as $piece) {
            $val = dechex($piece);
            $hex .= strlen($val) == 1 ? "0".$val : $val;
            $hex .= ":";
        }
        return trim($hex,":");
    }

    /**
     * @return string
     */
    public function getValueAsBytes() {
        $out = $this->value;
        if ($this->value < 1024) $out = $this->value . "B";
        if ($this->value == 0) $out = $this->value;
        if ($this->value > 1024) $out = round($this->value/1024, 2) . "K";
        if ($this->value > 1048576) $out = round($this->value/1048576, 2) . "M";
        if ($this->value > 1073741824) $out = round($this->value/1073741824, 2) . "G";
        if ($this->value > 1099511627776) $out = round($this->value/1099511627776, 2) . "T";
        return $out;
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