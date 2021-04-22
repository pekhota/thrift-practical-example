<?php

use Thrift\Protocol\TBinaryProtocol;
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

$transport = new TBufferedTransport(new TPhpStream(TPhpStream::MODE_R | TPhpStream::MODE_W));
$protocol = new TBinaryProtocol($transport, true, true);

$transport->open();
$processor->process($protocol, $protocol);
$transport->close();
