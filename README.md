# Internship System
Simple system for tracking internship

First clone the project, then run:
```bash
composer install
```
next run db/database.sql query then
```bash
cp .env.example .env
```
in .env enter you db credentials, then run:
```bash
vendor/bin/phinx init
```
in phinx.php under development environments enter your db credentials and run to seed db
```bash
vendor/bin/phinx seed:run
```
Now you can start the server and test endpoints

