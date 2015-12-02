#!/bin/bash

source /etc/shaggy/shaggy.conf
. `pwd`/fs_action.sh

function bind_directories() {
	echo Binding directoryes
	fs_bind ${1}
}

function unbind_directories() {
	echo Direcories unbinded
	fs_unbind ${1}
}

function copy_files() {
	echo Copyng files
	cp -f /etc/resolv.conf	${1}/etc/resolv.conf
	cp -f /usr/bin/qemu-arm	${1}/usr/bin/qemu-arm
}

for arch in ${FSPATH}/fs_*; do
if [ -d ${arch} ]; then
	export LANG=C
	echo CHROOT\'ing into ${arch} directory
	bind_directories ${arch}
	echo Copy supporting files
	copy_files ${arch}
	echo Realy entering CHROOT ${arch}
	chroot ${arch} emerge --deep --update --newuse --with-bdeps=y @world
	chroot ${arch} emerge --depclean
	chroot ${arch} eclean packages
	chroot ${arch} /usr/local/bin/mk-nfsroot.sh
	chroot ${arch} /usr/local/bin/mk-stage4.sh

	echo Exit CHROOT ${arch}
	unbind_directories ${arch}
fi
done
