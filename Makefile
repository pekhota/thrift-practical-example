gen-php:
	thrift --gen php:server -r --out ./packages ./idl/hello.thrift

gen-golang:
	thrift --gen go -r --out ${HOME}/go/src ./idl/hello.thrift

composer-install:
	composer install
up:
	docker-compose up -d