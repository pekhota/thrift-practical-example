<?php

use Thrift\Factory\TProtocolFactory;
use Thrift\Factory\TTransportFactory;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Server\TServerTransport;
use Thrift\Transport\TBufferedTransport;
use Thrift\Transport\TPhpStream;

require_once __DIR__."/vendor/autoload.php";

error_reporting(E_ALL);
ini_set("display_errors", "stderr");

$loader = new \Thrift\ClassLoader\ThriftClassLoader();
$loader->registerNamespace("example", __DIR__."/packages");
$loader->register();

class CalculatorHandler implements \example\CalculatorIf {

    public function add($num1, $num2)
    {
        return $num1 + $num2;
    }
}

$handler = new CalculatorHandler();
$processor = new \example\CalculatorProcessor($handler);

$transport = new \Thrift\Server\TServerSocket();

$server = new \Thrift\Server\TSimpleServer(
    $processor,
    $transport,
    new TTransportFactory(),
    new TTransportFactory(),
    new \Thrift\Factory\TBinaryProtocolFactory(true, true),
    new \Thrift\Factory\TBinaryProtocolFactory(true, true)
);

$server->serve();
