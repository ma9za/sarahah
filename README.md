
# Project Title

## Description

This project consists of two main PHP files:

1. `index.php`: Manages PHP sessions and connects to an SQLite database.
2. `cre.php`: Creates a table in the SQLite database.

## Installation

### Prerequisites

- PHP >= 7.0
- SQLite3

### Steps

1. Clone the repository.
   ```
   git clone <repository_url>
   ```

2. Navigate to the project directory.
   ```
   cd <project_directory>
   ```

3. Run `cre.php` to create the necessary database and tables.
   ```
   php cre.php
   ```

4. Start the PHP server.
   ```
   php -S localhost:8000
   ```

5. Open `index.php` in your web browser by visiting `http://localhost:8000/index.php`.

## Usage

- Use `index.php` to manage your sessions and perform database operations.
- Run `cre.php` whenever you need to create or update the database tables.

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License

[MIT](https://choosealicense.com/licenses/mit/)
