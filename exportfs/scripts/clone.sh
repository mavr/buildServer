#!/bin/bash
source /etc/shaggy/shaggy.conf

. ${SCRIPTPATH}/fs_action.sh

fs_clone $1 $2

