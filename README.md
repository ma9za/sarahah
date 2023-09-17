# Sarahah

## Project Link

[GitHub Repository](https://github.com/ma9za/sarahah)

## Description

This project consists of two main PHP files:

1. `index.php`: Manages PHP sessions and connects to an SQLite database.
2. `cre.php`: Creates a table in the SQLite database and sets up the admin account.

## Installation and Configuration

### Prerequisites

- Web server with PHP support (e.g., Apache or Nginx)
- PHP >= 7.0
- SQLite3

### Steps

1. Download the project files and upload them to your web server.

2. Navigate to `cre.php` in your web browser to set up the database.
   ```
   http://your-domain.com/cre.php
   ```
   This will create the necessary database and tables.

### Add or Update Admin

To add a new admin or update existing admin credentials, edit the following line in `cre.php`:
```
$adminQuery = "INSERT OR IGNORE INTO admin (username, password) VALUES ('admin', '123456')";
```
Replace `'admin'` and `'123456'` with the desired username and password.

## Usage

- Visit `index.php` to manage your sessions and perform database operations.

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License

[MIT](https://choosealicense.com/licenses/mit/)
