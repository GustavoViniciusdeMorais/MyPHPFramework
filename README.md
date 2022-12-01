# Laravel Setup DockerFiles

I build this repository to save the setup for Laravel projects with my docker files.

Created by: Gustavo Vinicius

```
/etc/init.d/mysql stop

sudo docker-compose up -d --build
sudo docker exec -it [-u 0] [container_name] sh
sudo docker-compose down

sudo docker inspect [CONTAINER_ID] | grep IP

chmod +x composer.sh
./composer.sh

composer create-project laravel/laravel:^8.0 appname

cp -R appname/* .
rm -rf appname/

php artisan key:generate

chmod +x clearcash.sh
./clearcash.sh

php artisan key:generate

php artisan db:seed --class=GroupSeeder

php artisan db:seed --class=UserSeeder

sudo git remote set-url origin https://[token]@github.com/Repository
```

### Laravel 8

- Configurations
    - Cop the .env file and setup the mysql IP container and auth data

### TDD Laravel 8

- Steps:
    - php artisan make:test BasicTest
        - This class will be at tests/Feature/ folder.
    - chmod -R 777 ./
    - chmod +x composer.sh
    - ./composer.sh
    - Import the class to be tested into the Test class.
    - Rename the BasicTest method.
    - Inside the method write the test.
        - Use $this->assertEquals('RESULT', $result);
    - Run the command php artisan test

```
php artisan test
```

![TDD](/imgs/tddLaravel.png)