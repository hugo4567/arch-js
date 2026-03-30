#!/bin/bash
# Sauvegarder l'état de code-server
systemctl stop code-server
systemctl stop ssh
systemctl isolate rescue.target
sleep 2
pm-suspend