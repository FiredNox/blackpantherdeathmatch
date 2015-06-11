#!/bin/bash
cd /games/samp/ClassTeszt
screen -AdmS ClassTeszt_process ./samp03svr
echo "fut" > /var/www/usercp/control/ClassTeszt.co
