package main

import (
	"context"
	"fmt"
	"github.com/apache/thrift/lib/go/thrift"
	"hello"
	"log"
)

type CalculatorHandler struct {
}

func (c *CalculatorHandler) Add(ctx context.Context, num1 int32, num2 int32) (_r int32, _err error) {
	return num1 + num2, nil
}

func NewCalculatorHandler() *CalculatorHandler {
	return &CalculatorHandler{}
}

func must1(err error)  {
	if err != nil {
		log.Fatal(err)
	}
}

func main() {
	addr := "127.0.0.1:9090"
	protocolFactory := thrift.NewTBinaryProtocolFactoryConf(nil)

	transportFactory := thrift.NewTTransportFactory()

	transport, err := thrift.NewTServerSocket(addr); if err != nil { log.Fatal(err) }

	calculatorHandler := NewCalculatorHandler()
	processor := hello.NewCalculatorProcessor(calculatorHandler)

	server := thrift.NewTSimpleServer4(processor, transport, transportFactory, protocolFactory)
	fmt.Println("Starting the simple server... on ", addr)

	must1(server.Serve())
}
