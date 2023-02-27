#!/bin/sh
find /home/david/www/xai.zone -type f -not \
    -name 'index.php' -not \
    -name 'robots.txt' -not \
    -name 'readme' -not \
    -name 'cleanup.sh' -not \
    -path '/home/david/www/xai.zone/.*' \
    -mtime +14 | xargs rm
