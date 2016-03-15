#!/bin/bash
echo "enter a commit message and press return:"
read MESSAGE
make
git add build/**
git add src/**
git commit -m $MESSAGE && git push
git ftp push
