package main

import (
	"context"
	"github.com/apache/thrift/lib/go/thrift"
	"hello"
	"log"
)

func must(err error) {
	if err != nil { log.Fatal(err) }
}

func main() {
	client, err := thrift.NewTHttpClient("http://localhost:8080");  if err != nil { log.Fatal(err) }
	transport := thrift.NewTBufferedTransport(client, 1024)

	protocolFactory := thrift.NewTBinaryProtocolFactoryConf(nil)

	must(transport.Open())

	calculatorClient := hello.NewCalculatorClientFactory(transport, protocolFactory)
	res, err := calculatorClient.Add(context.Background(), 22, 23); if err != nil { log.Fatal(err) }
	log.Println(res)

	must(transport.Close())
}
