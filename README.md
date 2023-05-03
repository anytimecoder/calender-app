# Requirements for running locally
- php 8.1
- php-sqlite3


# Notes on implementation
- Used `breeze` to bootstrap vue/vite, will try to remove extra views/routes, but might miss some.
- Used sqlite for simplicity, for real application would have used PostgreSql or MySql/MariaDb.
- Added UserSeeder to .gitignore, since it contains potentially sensitive information. I wouldn't use seeder with real data in real project implementation.
- Debated with myself whether User entity (from Usergems) should also be a Person, but decided against it, since User is missing almost all information that is available for Person.


# Notes to self
- !!! Provide Users seeder and database.sqlite 
