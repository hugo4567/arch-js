#!/bin/bash
# Sauvegarder l'état de code-server
systemctl stop code-server
systemctl stop ssh
systemctl isolate rescue.target
sleep 2
pm-suspend

# Essayer pm-suspend
pm-suspend

# Ou acpi
acpitool -s

# Ou s2ram
s2ram