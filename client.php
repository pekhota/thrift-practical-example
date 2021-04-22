<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__."/vendor/autoload.php";

$loader = new \Thrift\ClassLoader\ThriftClassLoader();
$loader->registerNamespace("example", __DIR__."/packages");
$loader->register();

try {
//    $http = new \Thrift\Transport\THttpClient("localhost", 8080);
    $http = new \Thrift\Transport\TSocket("localhost", 9090);
    $transport = new \Thrift\Transport\TBufferedTransport($http, 1024, 1024);

    $protocol = new \Thrift\Protocol\TBinaryProtocol($transport);

    $transport->open();

    $client = new \example\CalculatorClient($protocol);
    $sum = $client->add(10, 15);

    echo "Sum1: $sum";


    $transport->close();
} catch (\Throwable $e) {
    echo get_class($e)."\n";
    echo "Exception: {$e->getMessage()}\n";
}
