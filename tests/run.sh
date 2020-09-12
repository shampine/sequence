#!/bin/bash
DIRECTORY=$(cd `dirname $0` && pwd)

$DIRECTORY/../vendor/bin/phpstan analyse src tests --level=7
$DIRECTORY/../vendor/bin/phpunit
