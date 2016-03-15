#!/bin/bash
SOURCE=${1/src\/}
echo "copying $SOURCE"
cd src
cp --parents $SOURCE ../build
