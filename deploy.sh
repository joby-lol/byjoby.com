#!/bin/bash
git commit -a -m "deployment build" && git push
git ftp push
