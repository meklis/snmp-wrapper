<?php


$snmp = new \SNMP(\SNMP::VERSION_2C, "10.1.1.11", 'billing', 10000);
$snmp->oid_output_format = SNMP_OID_OUTPUT_NUMERIC;
$snmp->quick_print = true;
$snmp->max_oids = 30;
$snmp->oid_increasing_check = false;
$snmp->valueretrieval = SNMP_VALUE_OBJECT;
print_r($snmp->walk(
    ['1.3.6.1.2.1.2.2.1.1', '1.3.6.1.2.1.2.2.1.2']
, false));