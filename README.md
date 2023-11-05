# We3World Documentation

##Introduction

This coding challenge is part of the interview process for the Laravel Backend Developer position at We3World. The purpose of the challenge is to assess my skills and expertise in PHP and Laravel, and to evaluate my ability to build an api application.

The challenge required: me to build a web application that loads order data from a CSV file and component data from an engineering component API, and uses this information to generate amusing robot names based on the most prevalent category of components in each order. I was also needed to display the results in a table on a web page.
Requirements:

Backend (Laravel):
- Set up a RESTful API using Laravel to manage tasks.
- Each task should have: id, title, description, due_date, and status (e.g., pending, completed).
- Implement routes for creating, retrieving, updating, and deleting tasks.
- Store tasks in a relational database (e.g., MySQL). Use migrations for setting up the database schema.
- Implement authentication. Users should be able to register and log in. Protect the task routes to ensure only authenticated users can access them.
- Use middleware to handle API versioning.
- Write tests for your API endpoints using PHPUnit.

Frontend:
- Create a user-friendly interface to interact with the task API.
- Users should be able to:
  - Register and log in/out.
  - View a list of their tasks.
  - Add new tasks.
  - Edit and delete existing tasks.
  - Filter tasks by status (e.g., show only pending tasks).
- You may use a frontend framework or library of your choice (e.g., Vue.js, React, etc.).
- Use Laravel Mix for asset compilation and management.
- Ensure the UI is mobile-responsive.

Bonus (not mandatory):
- Implement pagination for the list of tasks.
- Add the ability for users to upload and attach files to tasks.
- Implement role-based access control. E.g., normal users vs. admin users.
- Use WebSockets (e.g., Laravel Echo with Pusher or Socket.io) to notify users of impending due dates for tasks.
- Add unit and feature tests for the frontend.

General Guidelines:
- Prioritize functionality over design, but make sure the UI is user-friendly and intuitive.
- Make sure to handle potential errors gracefully.
- Provide instructions for setting up and running the application, preferably using a README file.
- Push the code to a repository (e.g., GitHub, GitLab) and share the link.



## Installation & Setup (Windows)

###1. Installing XAMPP
1. Download XAMPP:
    - Visit the official website of [XAMPP](https://www.apachefriends.org/download.html).
    - Download the installer suitable for your operating system (Windows, macOS, Linux).


2. Run the Installer:
    - Execute the downloaded installer file.
    - Follow the on-screen instructions provided by the installer.


3. Component Selection:
    - During installation, ensure you select the following components:
        - PHP
        - MySQL
        - PHPMyAdmin


4. Starting Services:
    1. Launch XAMPP Control Panel:
        - Once installation is complete, launch the XAMPP Control Panel.
    2. Start Apache:
        - In the XAMPP Control Panel, locate the Apache module.
        - Click the "Start" button next to it.
    3. Start MySQL:
        - In the same XAMPP Control Panel, locate the MySQL module.
        - Click the "Start" button next to it.


5. Testing the Installation:
    - Open a web browser.
    - Enter http://localhost in the address bar and press Enter.
    - If everything is set up correctly, you should see the XAMPP dashboard.

###2. Installing Composer for Laravel
1. Download Composer:
    - Visit the  Composer [download page](https://getcomposer.org/download/).
    - Download the `Composer-Setup.exe` file.


2. Run the Installer:
    - Execute the downloaded `Composer-Setup.exe` file.
    - Follow the on-screen instructions provided by the installer.
    - Make sure to check the box that says "Add PHP to PATH"


3. Verification:
    - Open the Command Prompt.
    - Run `composer --version`.
    - If the installation was successful, you should see output displaying the version of Composer installed.

###3. Setting up the Database
1. Access PHPMyAdmin:
    - Open the XAMPP Control Panel.
    - Click the "Admin" button next to MySQL. This will open PHPMyAdmin in your default web browser.


2. Create a New Database:
    - In PHPMyAdmin, click the "Databases" tab at the top.


3. Name the Database:
    - Create a new database with the exact name "accu_bot".

###4. Setting up the Git Bash
1. Download Git Bash:
    - Visit the official [Git website](https://git-scm.com/downloads).
    - Download the Windows version installer.


2. Install Git Bash:
    - Run the installer.
    - Follow the on-screen instructions. Make sure to pay attention to any additional options or configurations offered during the installation.


3. Configure Git:
    - Open Git Bash after installation.
    - Set your username and email address by running the following commands (replace `Your Name` and `your@email.com` with your actual name and email):
        - `git config --global user.name "Your Name"`
        - `git config --global user.email your@email.com`

###5. Setting up the Project
1. Cloning
    1. Go to the GitHub.com [repository](https://github.com/DavidLokeNemeth/AccuBotFactory).
    2. Above the list of files, click the green Code button.
    3. Copy the URL for the repository.
        - To clone the repository using HTTPS, under "HTTPS", click the copy icon.
    4. Open Git Bash.
    5. Change the current working directory to the location where you want the cloned directory.
    6. Type git clone, and then paste the URL you copied earlier.
        - `git clone https://github.com/DavidLokeNemeth/We3World.git`
    7. Press Enter to create your local clone.


2. Navigate to Project Directory:
    - Open the Command Prompt.
    - Use the `cd` command to navigate to the project directory.


3. Set Up Environment Variables:
    - Laravel uses an environment file (.env) to manage configuration variables. Copy the .env.example file and rename it to .env: `cp .env.example .env`.


4. Install Dependencies:
    - Run `composer install` to install project dependencies.


5. Generate Application Key:
    - Run the following command to generate an application key, which is used for encrypting sensitive data: `php artisan key:generate`


6. Migrate Database:
    - Run the following command to create the necessary database tables: `php artisan migrate`.


###6. Running PHPUnit Tests
Execute Tests:
- Open your command prompt or terminal.
- Use the `cd` command to navigate to the project directory.
- Run the following command to execute the PHPUnit tests: `php artisan test`.
- After a short time, you should see the output indicating the number of tests that passed and the total number of assertions.



###7. Application Usage
Because had no time actually start any frontend work, the app can only be used with API calls.
Make sure you set the headers `Accept` to `application/json`.

1. Make sure the application is running with the `php artisan serve`.


2. Create a user by sending a post request to the `http://127.0.0.1:8000/api/register` which contain the following fields:
    - name
    - email
    - password
    - password_conformation

   As answer you get your token which you need to save for the task actions.

    
3. In case you already registered you can login by sending your email and password to the `http://127.0.0.1:8000/api/login`.

   As answer you get your token which you need to save for the task actions.


4. Before you do any task action you need set your API Authorization to Bearer Token and to the token field past your token from the registration/login.


5. You can make the following task actions:
   1. To get all task you need to send a get request to `http://127.0.0.1:8000/api/tasks`.
   2. To get specific task you need to send a get request to `http://127.0.0.1:8000/api/tasks/{id}` where id is the task id.
   3. To create a new task you need to send a post request to `http://127.0.0.1:8000/api/tasks` which contains the task:
      - title
      - description
      - due_date
   4. To update a task you need to send a put request to `http://127.0.0.1:8000/api/tasks/{id}` which contains those fields you wish to update. (see above and status as extra).
   5. To delete a task you need send a delete request to `http://127.0.0.1:8000/api/tasks/{id}`.
