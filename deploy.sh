#!/bin/bash
git add build/**
git commit -a -m "deployment build" && git push
git ftp push
