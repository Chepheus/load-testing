#!/usr/bin/env bash

cd siege && docker build -t yokogawa/siege . && cd ..
docker-compose up -d

echo "Use:"
echo "docker run --network custom_network --rm -t yokogawa/siege -r100 -c255 http://nginx-php/"