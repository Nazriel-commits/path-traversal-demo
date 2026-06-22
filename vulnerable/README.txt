# Path Traversal Demo Project

This is a small PHP web application designed to demonstrate **path traversal vulnerabilities** in a controlled environment.

------------------------------------------------------------------------------------------------------------------------------

## Project Structure

- login.php — Log in to the application.  
- register.php — Register a new user (saves to `users.txt`).  
- welcome.php — Homepage after login, shows available files.
- fileviewer.php — Displays file contents based on `file` parameter in the URL. **This file is intentionally vulnerable to path traversal attacks.**  
- logout.php — Logs the user out.  
- users.txt — Stores usernames and passwords in the format `username:password`.  
- /files/ — Directory containing text files:  
  - welcome.txt  
  - about.txt  
  - notes.txt  
  - secret.txt — Admin-only file.  

---

## User Accounts

### Predefined Admin Accounts
- AdminNaz / naz123
- AdminYihang / yihang123  

### Predefined Non-Admin Accounts
- TestUser1 / password1
- TestUser2 / password2
- TestUser3 / password3  

> Admin accounts can access `secret.txt`. Non-admin users can see the file in the list, but attempting to open it will show an **“Access denied”** message.

---

## Path Traversal Demonstration

1. Log in with **any account**.  
2. Go to `welcome.php` and click on files in the list.  
3. Try exploiting the path traversal vulnerability by manually editing the URL:  


- ../users.txt — Lets you view the contents of `users.txt` (including usernames and passwords of all accounts, admins included).
  
- ../../../../../etc/passwd — Lets you view the system password file (common Linux system info, no actual passwords).

NOTE: Need at least 5 ../ for second attack to work  

---------------------------------------------------------------------------------------------------------------------------------

## Setup Instructions

1. Make sure apache is installed, if not just run:

sudo apt update
sudo apt-get install apache2

2. Install PhP and extensions

sudo apt install -y php
sudo apt install -y php php-common php-mysql php-cli php-curl php-gd php-xml php-mbstring

3. No need for SQL databases as premade accounts have already been made for the sake of the assignment.

4. Set up the web server

cd /home/student/Downloads
sudo mkdir /var/www/html/path-traversal
sudo cp -r /home/student/Downloads/Path_traversal/* /var/www/html/path-traversal

5. Change ownership to the web server

sudo chown -R www-data:www-data /var/www/html/path-traversal

6. Set folder and file permissions

sudo find /var/www/html/path-traversal -type d -exec chmod 775 {} \;
sudo find /var/www/html/path-traversal -type f -exec chmod 664 {} \;

7. Visit browser

http://localhost/path-traversal/login.php

8. Log-in with any of the accounts listed on users.txt
