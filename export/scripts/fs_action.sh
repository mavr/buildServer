#!/bin/bash

source /etc/shaggy/shaggy.conf

function fs_bind() {
	mount -o bind /proc		${1}/proc
	mount -o bind /sys		${1}/sys
	mount -o bind /dev		${1}/dev
	mount -o bind /dev/pts	${1}/dev/pts
	mount -o bind /dev/shm	${1}/dev/shm
	
	if ! [ -d ${1}/usr/portage/ ]; then
		echo "There is no usr/portage directory.Creating."
		mkdir -p ${1}/usr/portage
	fi
	
	mount -o bind /usr/portage	${1}/usr/portage
}

function fs_unbind() {
	umount ${1}/usr/portage
	umount ${1}/dev/shm
	umount ${1}/dev/pts
	umount ${1}/dev
	umount ${1}/sys
	umount ${1}/proc
}

function fs_clone() {
	mkdir ${FSPATH}/${2}

	if ! [ -d ${FSPATH}/${1} ]; then
		echo "Error: no such directory ${1}"
		exit -1
	fi
	umount ${FSPATH}/${1}/usr/portage 2> /dev/null
	umount ${FSPATH}/${1}/dev/shm 2> /dev/null
	umount ${FSPATH}/${1}/dev/pts 2> /dev/null
	umount ${FSPATH}/${1}/dev 2> /dev/null
	umount ${FSPATH}/${1}/sys 2> /dev/null
	umount ${FSPATH}/${1}/proc 2> /dev/null

	cp -r ${FSPATH}/${1}/* ${FSPATH}/${2}/

	exit 0
}
