#!/bin/bash
echo "enter a commit message and press return:"
read MESSAGE
make
git add build/**
git commit -a -m $MESSAGE && git push
git ftp push
