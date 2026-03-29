#!/bin/bash
# /usr/local/bin/sleep-pc.sh
echo 0 > /sys/class/rtc/rtc0/wakealarm
echo $(date -d "tomorrow 07:00" +%s) > /sys/class/rtc/rtc0/wakealarm
pm-suspend