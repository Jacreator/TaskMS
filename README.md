<p align="center">
TASK MANAGEMENT SYSTEM WITH D&G
</p>

## About TMS

This is a simple task management project built with some functionalities, such as:

- [drag and drop]('').
- [Priority level](').
- [Edit task]('') and [Delete task]('').
- [Add member to workspace]('').
- [Create Project]('').
- [CRUD on Task]('') and [Assign members to task]('').
- [Assign Task to Project]('').
- [Update Priority level base on Drag and Drop]('')


## Running the TMS
 
- composer install
- Create a database file on your local system
- configure your .env file to point to the database
-- DB_CONNECTION=mysql
-- DB_HOST=127.0.0.1
-- DB_PORT=3306
-- DB_DATABASE="your name of db"
-- DB_USERNAME="your server username"
-- DB_PASSWORD="your serever password"

- Run php artisan migrate --seed
- Run npm run dev

## This project have some Assumptions
 such as:
- Only an admin will have the right to create member
- A project is need to create a task
- To test the software smoothly its advice to create at least two of each task, project and user

## Admin details for first login

- Username: james@test.com
- Password: password

### Contact Me

- **[LinkedIn](https://linkedin.com/in/jacreator)**
