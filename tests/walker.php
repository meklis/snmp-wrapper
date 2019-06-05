<?php

require __DIR__ . "/../vendor/autoload.php";


$snmp = new SnmpWrapper\WrapperWorker();

$walker = new \SnmpWrapper\Walker($snmp);

$walker->setTimeout(3)
       ->setRepeats(2)
       ->setIp("10.50.124.132")
       ->setCommunity("oblnswsnmpcomrw")
       ->useCache(false);

$oids = [
   '.1.3.6.1.2.1.1.1',
   '.1.3.6.1.2.1.1.3',
];

foreach ($walker->walk($oids) as $resp) {
    echo $resp->getIp() . " - " . $resp->getOid() . "\n";
    foreach ($resp->getResponse() as $snmpResp) {
        echo "VALUE: {$snmpResp->getType()}, BIN: {$snmpResp->getValueAsBinary()}, HEX: {$snmpResp->getHexValue()}\n";
        echo "OID: {$snmpResp->getOid()} - {$snmpResp->getOidAsHex()} \n";
    }
}