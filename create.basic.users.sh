sudo php app/console doctrine:schema:update --force

sudo php app/console  fos:user:create  cristian cristianchaparroa.test@gmail.com 1032
sudo php app/console fos:user:promote cristian ROLE_DIRECTOR

sudo php app/console  fos:user:create  admin cristianchaparroa@gmail.com 1032
sudo php app/console fos:user:promote admin ROLE_ADMIN

sudo php app/console fos:user:create paulogaona alonso.cursos@gmail.com 1234
sudo php app/console fos:user:promote paulogaona  ROLE_ADMIN
