#!/bin/bash

cd /var/www/share/sleepz19.c-111.maxcluster.net/htdocs/shell/

sleep 2

php price_comparison.php --export shopzilla --store_view ps_de --ignore_unvisible no #> /dev/null 2>&1

mv /var/www/share/sleepz19.c-111.maxcluster.net/htdocs/export/price_comparison/tmp/ps_de_shopzilla.csv /var/www/share/sleepz19.c-111.maxcluster.net/htdocs/export/price_comparison/ps_de_shopzilla.csv

exit 0