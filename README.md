connection refused problem

use 10.0.2.2



//second

https://stackoverflow.com/questions/63429630/illuminate-database-queryexception-sqlstatehy000-1045-access-denied-for-us

The error means Laravel is trying to connect to the database with invalid credentials.

Whenever you make a change to the .env file in Laravel you need to reset the cache. You need to run this command:

php artisan config: cache
