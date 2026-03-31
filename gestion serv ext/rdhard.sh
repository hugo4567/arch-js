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
# Éditer crontab
crontab -e 1er file
/etc/systemd/system/sleep-at-time.service 2e file


# Créer un tunnel SSH via code-server (port forwarding)
ssh -L 2222:localhost:22 root@code-server-ip