php app/console doctrine:schema:update --force

php app/console  fos:user:create  cristian cristianchaparroa.test@gmail.com 1032
php app/console fos:user:promote cristian ROLE_DIRECTOR

php app/console  fos:user:create  admin cristianchaparroa@gmail.com 1032
php app/console fos:user:promote admin ROLE_ADMIN

php app/console fos:user:create paulogaona alonso.cursos@gmail.com 1234
php app/console fos:user:promote paulogaona  ROLE_ADMIN
