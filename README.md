-To run frontend you will need node (latest version) and npm installed in your machine
1. Open a terminal in the frontend folder
2. run: npm i
3. run: npm run dev

-To run backend you will need php (version 8.2) and composer installed in your machine
1. Open a terminal in the backend folder
2. run: composer install
3. create database named 'inventory_management', user 'root', no password
4. run: php artisan migrate:fresh
5. run: php artisan serve
