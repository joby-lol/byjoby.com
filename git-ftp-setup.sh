#!/bin/bash
#  -------------------------------------------
# | git-ftp deployment environment setup file |
#  -------------------------------------------
#
# This file sets up your environment for using git-ftp for deployment, once you
# have git-ftp installed, set up this file and run it, you will be able to push
# to the live servers using a single command in Bash.
#
# This workflow was designed to refer to "production" as "master," and "test"
# as "staging." This coincides with the "master" and "staging" branches in the
# git repo. This is to take advantage of the fact that git-ftp can use the
# current branch as a scope for deployment. This means that if you're currently
# in the staging branch, you run `git ftp deploy -s` and it will deploy to the
# staging scope. Likewise for the master branch, running the exact same command
# `git ftp deploy -s` will deploy to production.
#
# For help setting up and understanding git-ftp see:
# README:  https://github.com/git-ftp/git-ftp/blob/develop/README.md
# INSTALL: https://github.com/git-ftp/git-ftp/blob/develop/INSTALL.md
# MAN:     https://github.com/git-ftp/git-ftp/blob/develop/man/git-ftp.1.md

user="joby@byjoby.net"
server="ftp://ftp.byjoby.net"
pathmaster="/public_html/byjoby.com"

# prompt user for password
echo "This script will configure your local environment to deploy this site"
echo "Please enter the FTP password for user $user on server $server"
read password

# global settings
git config git-ftp.user $user
git config git-ftp.password $password
git config git-ftp.url $server$pathmaster
