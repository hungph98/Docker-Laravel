##Create Enviroment
1. Install docker
2. Clone this project
3. Switch to develop branch
4. Copy file .env.example to .env
```
cp .env.example to .env
```
5. Copy file 
```
cd source
cp .env.example to .env
```
6. Build docker and up
```
make build
make start
```
7. Composer install
```
make ssh
composer install
php artisan key:generate
```
8. Migrate database
```
make ssh
php artisan migrate
```
9. Note
- Backend
   - Use Framework laravel 8
   - Use l5-repository: https://github.com/andersao/l5-repository
   - Sample example: Api/ExamplesController.php
   - UI > Controller > Service > Repository > Model/Database
10. Basic command
  - Gen repository: model, repository, migration
    `php artisan make:repository Post`
  - Import 
    `php artisan make:bindings Post`
  - Create a Presenter using the command
    `php artisan make:transformer Post`
  - Create a Transformer using the command
    `php artisan make:presenter Post`
