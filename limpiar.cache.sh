sudo php app/console assets:install
sudo php app/console --env=dev cache:clear
sudo php app/console --env=prod cache:clear
sudo chmod -Rf 777 app/cache
sudo chmod -Rf 777 app/logs
