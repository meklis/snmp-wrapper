<?php


namespace SnmpWrapper\NoProxy;


interface SnmpInterface
{
    function __construct(string $ip, string $community, int $timeout_ms  = null, $retries = null);
    function walk(string $oid);
    function get(string $oid);
    function multiGet(array $oids);
    function set(string $oid, string $type, $value);
    function multiWalk(array $oid);
}