#!/bin/bash
DIRECTORY=$(cd `dirname $0` && pwd)

$DIRECTORY/../vendor/bin/phpstan analyse src tests
$DIRECTORY/../vendor/bin/phpunit --coverage-text --testdox
