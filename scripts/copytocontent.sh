#!/bin/bash
SOURCE=${1/content\/}
echo "copying $SOURCE"
cd content
cp --parents $SOURCE ../build
