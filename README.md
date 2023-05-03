# Requirements for running locally
- php 8.1
- php-sqlite3


# Notes on implementation
- This is my first ever project with Laravel
- Used `breeze` to bootstrap vue/vite, will try to remove extra views/routes, but might miss some.
- Used sqlite for simplicity, for real application would have used PostgreSql or MySql/MariaDb.
- Added UserSeeder to .gitignore, since it contains potentially sensitive information. I wouldn't use seeder with real data in real project implementation.
- Debated with myself whether User entity (from Usergems) should also be a Person, but decided against it, since User is missing almost all information that is available for Person. In the end I should have actually made it the other way - it would have been easier to deal with meeting attendees.
- Didn't have time to persist person/company data to DB
- Found out about Carbon too late to use it in full potential
- Didn't have enough time for frontend implementation, sadly

# Notes to self
- !!! Provide Users seeder and database.sqlite 
