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
   '.1.3.6.1.2.1.2.2.1.7',
   '.1.3.6.1.2.1.2.2.1.8',
   '.1.3.6.1.2.1.2.2.1.9',
   '.1.3.6.1.2.1.2.2.1.14',
   '.1.3.6.1.2.1.2.2.1.20',
   '.1.3.6.1.2.1.17.7.1.1.4',
   '.1.3.6.1.2.1.17.7.1.1.1',
];

print_r($walker->walk($oids));