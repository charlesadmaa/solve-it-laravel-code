## Introductory guide

This is a laravel application, bascially we would want to follow the conevectional installation guide for starting up a laravel application, however i have added a little bit spice to it, during the development stage i added docker, so that we would have a virtual container setup in no time.

Basically we would want to have docker on our computer, then run the following series of command, cd into project root, then 
`cp .env.example .env`,  
then run `docker compose build` to build container and download the required tool kit and php extensions
then run `docker compose up -d` to start up the docker container silently / in the background without viewing the matrix,

Then we would want to exec into the container, typically it should be `docker exec -it "app-container-name or id with or without quotes" bash` with the container setup i have made, the following should work just fine `docker exec -it solveit-app bash` when inside the container, we would want to install composer by running `composer install` after which we would want to run the following set of commands 
`php artisan key:generate` followed by
 `php artisan jwt:secret` lastly we would want to create a mysql connection using tools like "HiedSQL" (Hoping i spelt this correctly), or MysqlWorkBench, or DbBeaver or which ever one is convinent, after starting the connection, we might want to go ahead to create the following database table `solveitapps-db`, (If you are using Hiedies the connection details should be hostname: 127.0.0.1 or localhost, the port should be 3306, username and password should be found in the .env file : which is app and root respectively) after which we would go back into our application root then run `php artisan migrate:fresh --seed` to run database migrations and seeders, it is also advicable to run `php artisan optimize:clear` when needed.

For brevitiy, i have excluded a large chunk of code from this project, as the docker setup requires tools such as redis (for caching), socketi (A self hosted web socker server), plus it runs on Nginx server, the original project have a real time communication integration in its codebase, however i have removed it from this project for the purpose of brevity, if you need an advaance code sample, kidnly let me know as well.

This project has two part, one providing the API for an IONIC + Vue project i wrote and the main admin dashboard (which is also accesible at localhost:8000/admin, if the set up is done correctly, login credentials are located in the DB seeders folders for clarity here is a sample email: testadmin@solveit.com, password: admin)
Ideally it uses `JWT authentication` for the API routes and `Session` for the web route (Admin).

I will love to go on and on about the project, but i think this detailed information to spin up the project and view it in-depth, again, if this is too basic an example, please request for more advance code samples, I have alot of interesting and very large project to talk about and share their code samples.
