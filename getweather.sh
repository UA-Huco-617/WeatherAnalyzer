#!/usr/local/bin/bash
RANDOM=$$
# 900 secs == 15 mins
wait=$(expr $RANDOM % 900)
sleep $wait
/usr/local/bin/php /home/hquamen/weather/driver.php >> /home/hquamen/web-docs/weather/log.txt 2>&1
