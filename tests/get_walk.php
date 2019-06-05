<?php

require __DIR__ . "/../vendor/autoload.php";

//Initialize worker
$data = new SnmpWrapper\WrapperWorker();

//Formate request end sending
$response = $data->walk([
    (new SnmpWrapper\Request\PoollerRequest())
        ->setIp("10.50.124.132")
        ->setCommunity("public")
        ->setOid(".1.3.6.1.2.1.2.1")
        ->setUseCache(true),
    (new SnmpWrapper\Request\PoollerRequest())
        ->setIp("10.50.124.132")
        ->setCommunity("public")
        ->setOid(".1.3.6.1.2.1.2.2.1.5")
        ->setUseCache(true),
]);



print_r($data->get([
    (new SnmpWrapper\Request\PoollerRequest())
        ->setIp("10.50.124.132")
        ->setCommunity("public")
        ->setOid(".1.3.6.1.2.1.2.1.0")
        ->setUseCache(true),
]));