<?php

require __DIR__ . "/../vendor/autoload.php";

use SnmpWrapper\Device;
use SnmpWrapper\Oid;
use SnmpWrapper\WrapperWorker;
use SnmpWrapper\MultiWalker;

$snmp = new WrapperWorker("http://127.0.0.1:8080");

$walker = new MultiWalker($snmp);

$walker->addDevice(
    Device::init("10.50.124.132", "public")
);
$walker->addDevices(
    [
        Device::init("10.50.124.131", "public"),
        Device::init("10.50.125.132", "public"),
    ]
);

$oids = [
    (new Oid())->setOid('.1.3.6.1.2.1.1.1')->setUseCache(true),
    (new Oid())->setOid('.1.3.6.1.2.1.1.6')->setUseCache(true),
];

foreach ($walker->walk($oids) as $resp) {
    echo $resp->getIp() . " - " . $resp->getOid() . "\n";
    foreach ($resp->getResponse() as $snmpResp) {
        echo "VALUE: {$snmpResp->getType()}, BIN: {$snmpResp->getValueAsBinary()}, HEX: {$snmpResp->getHexValue()}\n";
        echo "OID: {$snmpResp->getOid()} - {$snmpResp->getOidAsHex()} \n";
    }
}