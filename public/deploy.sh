#!/bin/bash

LOG_FILE="/var/log/charge_deploy.log"

date >> "$LOG_FILE"
echo "Start deployment" >>"$LOG_FILE"
cd /opt/www/charge
echo "pulling source code..." >> "$LOG_FILE"
git pull origin master
echo git log -1>>"$LOG_FILE"
echo "Finished." >>"$LOG_FILE"
echo >> $LOG_FILE