#!/bin/bash

export LC_ALL=en_US.UTF-8

wget http://mobil.klart.se/malmö.html > /dev/null 2>&1

result=$(cat malmö.html | grep "temperature: '" malmö.html | grep -o "'.*'" | sed "s/'//g")

rm malmö.html

echo $result 

