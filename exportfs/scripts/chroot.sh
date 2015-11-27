#!/bin/bash

source /etc/shaggy/shaggy.conf

arch=${1}

echo Binding directoryes
mount -o bind /proc	${FSPATH}/${arch}/proc
mount -o bind /sys	${FSPATH}/${arch}/sys
mount -o bind /dev	${FSPATH}/${arch}/dev
mount -o bind /dev/pts	${FSPATH}/${arch}/dev/pts
mount -o bind /dev/shm	${FSPATH}/${arch}/dev/shm
mount -o bind /usr/portage	${FSPATH}/${arch}/usr/portage

echo Copyng files
cp -f /etc/resolv.conf	${FSPATH}/${arch}/etc/resolv.conf
cp -f /usr/bin/qemu-arm	${FSPATH}/${arch}/usr/bin/qemu-arm

echo Hello, chroot World!
export LANG=C
chroot ${FSPATH}/${arch} /bin/bash

echo Goodby, chroot World!
umount ${FSPATH}/${arch}/usr/portage
umount ${FSPATH}/${arch}/dev/shm
umount ${FSPATH}/${arch}/dev/pts
umount ${FSPATH}/${arch}/dev
umount ${FSPATH}/${arch}/sys
umount ${FSPATH}/${arch}/proc

echo Direcories unbinded
