php app/console assets:install
php app/console --env=dev cache:clear
php app/console --env=prod cache:clear
chmod -Rf 777 app/cache
chmod -Rf 777 app/logs
