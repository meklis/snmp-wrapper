<?php

require __DIR__ . '/../vendor/autoload.php';

$snmp = new \SnmpWrapper\NoProxy\PhpSnmp("10.1.1.11", 'billing');


$snmp = new \SnmpWrapper\NoProxy\MultiWalker();

$snmp->addDevices([
    \SnmpWrapper\Device::init("10.1.1.11", 'billing')
]);

print_r($snmp->walk([
    '.1.3.6.1.2.1.2.2.1.1',
]));
exit;
print_r($snmp->get('.1.3.6.1.2.1.2.2.1.1.27'));

exit;
print_r($snmp->walk(
    ['1.3.6.1.2.1.2.2.1.1', '1.3.6.1.2.1.2.2.1.2']
, false));