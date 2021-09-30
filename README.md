# Internship System
Simple system for tracking internship
## Installation
First clone the project, then run:
```bash
composer install
```
Run db/database.sql query, then:
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
Now you can start the server from /public and test endpoints

## Endpoints
### GET
 - /api/mentors/1
 - /api/interns/1
 - /api/groups/1
 - /api/groups?limit=5&page=2&sort=id&order=desc
 
 | Parameters  | Description     |
 | ----------- | --------------- |
 | limit       | Records per page|
 | page        | Current page    |
 | sort        | Sorted by       |
 | order       | Ordered by      |
 
### POST
 - /api/mentors 
 - /api/interns 
 
  | Parameters  |      
  | ----------- | 
  | first_name  |                 
  | last_name   |              
  | email       |
  | group_id    |
 
 - /api/groups
 
  | Parameters  |      
  | ----------- | 
  | name        |
  
   - /api/comments
   
   | Parameters  |      
   | ----------- | 
   | body        |
   | mentor_id   |
   | intern_id   |
  
### PUT 
 - /api/mentors/1 
 - /api/interns/1
 - /api/groups/1

### DELETE
 - /api/mentors/1 
 - /api/interns/1
 - /api/groups/1
