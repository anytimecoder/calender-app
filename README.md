# Requirements for running locally
- php 8.1
- php-sqlite3
- the project is missing `.env` and `UsersSeeder.php` files, which have been provided as separate Github gists files.
- With above files in place all the functionality can be run with these commands
```
php artisan migrate
php artisan db:seed
php artisan app:sync-events 
```
- `migrate` step will ask if sqlite file needs to be created. I can provide a copy of the database file with data already in it, if required.
- `sync-events` command will only populate empty data, since there are no emails to be sent today, can be used with other date (for testing), e.g:
```
php artisan app:sync-events 2022-07-01
```
above will actually produce results with data, that should correspond to the data required for email and layout, as there is actually a meeting on 2022-07-01  

# Notes on implementation
- This is my first ever project with Laravel
- Used `breeze` to bootstrap vue/vite, ~~will try to remove extra views/routes~~ (didn't remove any as didn't have time for frontend)
- Used sqlite for simplicity, for real application would have used PostgreSql or MySql/MariaDb.
- Added UserSeeder to .gitignore, since it contains potentially sensitive information. I wouldn't use seeder with real data in real project implementation.
- Debated with myself whether User entity (from Usergems) should also be a Person, but decided against it, since User is missing almost all information that is available for Person. In the end I should have actually made it the other way - it would have been easier to deal with meeting attendees.
- ~~Didn't have time to persist person/company data to DB~~ Persisted it
- Found out about Carbon too late to use it in full potential
- Didn't have enough time for frontend implementation, sadly
- There are TODO or FIXME comments in the code in places where I would fix things if had more time.
- JSON data for email is encoded to string as sqlite doesn't support json type

