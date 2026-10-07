# Announcement Page PHP App

## Run the project

1. Install XAMPP or another PHP server with the MySQL PDO extension enabled.
2. Put this folder inside XAMPP's `htdocs` folder.
3. Start Apache and MySQL in the XAMPP Control Panel.
4. Import `database.sql` through phpMyAdmin.
5. Open `http://localhost/Login_WS1_Jardenico/index.php` in a browser.

New users can select either a Student or Teacher account type at registration. The configured admin email is always registered as an Admin account.

## Admin account

1. Open `config.php`.
2. Replace the email address in `$adminEmails` with your own email address.
3. Register using that email address.
4. Log in. You will be sent to the Admin dashboard.

There is no demo password. Every account is created from the Register page.
