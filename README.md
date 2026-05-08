# PHP Image Uploader

A PHP-based image upload system designed as a backend component for content management systems (WordPress, Laravel, or custom frameworks). Upload images via a web form, store files on the server, and record metadata in a MySQL database.

---

## Features

- Image validation (type, size, PHP upload error checks)
- Unique filename generation using timestamps to prevent conflicts
- MySQL metadata storage with multi-level categorization
- Configurable upload directory and form fields
- Example gallery/archive display page
- Singleton DB connection wrapper with query escaping

---

## File Structure

```
img_uploader/
├── imgupload.form.php          # Upload form (HTML5 multipart)
├── upload.processor.php        # POST controller — core upload handler
├── upload.success.php          # Success confirmation page
├── displayimages.frontend.php  # Example gallery/archive display page
└── core/inc/
    ├── config.ini              # Database credentials
    ├── DB.inc.php              # MySQLi connection wrapper (singleton)
    └── DBQuerySelector.inc.php # Extended DB class with custom queries
```

---

## Requirements

- PHP 7+ with the `mysqli` extension
- MySQL server
- Web server with write access to the upload directory

---

## Installation

### 1. Place files in your web root

```bash
git clone <repo-url> /var/www/html/img_uploader
```

### 2. Create the database and table

```sql
CREATE DATABASE img_uploader;
USE img_uploader;

CREATE TABLE meme_collection (
  id       INT PRIMARY KEY AUTO_INCREMENT,
  url_loc  VARCHAR(255),
  series   VARCHAR(255),
  cat1     VARCHAR(255),
  cat2     VARCHAR(255),
  asso1    VARCHAR(255),
  asso2    VARCHAR(255)
);
```

### 3. Configure database credentials

Edit `core/inc/config.ini`:

```ini
[database]
username = your_mysql_user
password = your_mysql_password
dbname   = img_uploader
```

### 4. Create the images directory

```bash
mkdir -p /images
chmod 755 /images
```

> The upload path defaults to `$_SERVER['DOCUMENT_ROOT'] . 'images/'`. Adjust this in `upload.processor.php` if needed.

---

## Usage

1. Navigate to `imgupload.form.php` to open the upload form.
2. Select an image (max 5 MB) and fill in the optional metadata fields.
3. Submit — the processor validates, saves the file to `/images/`, and inserts a record into the database.
4. On success you are redirected to `upload.success.php`.
5. View all uploaded images via `displayimages.frontend.php`.

---

## Customization

| What to change | Where |
|---|---|
| Max file size | `$max_file_size` in `imgupload.form.php` |
| Upload directory | `$uploadsDirectory` in `upload.processor.php` |
| Database table name | `upload.processor.php` (hardcoded as `meme_collection`) |
| Metadata fields | Form fields in `imgupload.form.php` + INSERT query in `upload.processor.php` |
| Custom DB queries | Add methods to the `PILwall` class in `DBQuerySelector.inc.php` |
| Success UX | Replace `upload.success.php` redirect with a JS alert/modal |

---

## Components

### `DB.inc.php`
Singleton MySQLi wrapper. Key methods:
- `connect()` — reads `config.ini` and opens the connection
- `query()` — execute INSERT/UPDATE/DELETE
- `select()` — execute SELECT and return an array of associative arrays
- `quote()` — escape and quote values for safe SQL interpolation

### `DBQuerySelector.inc.php` (PILwall class)
Extends `DB` with application-specific queries:
- `Getmemes()` — fetch all records
- `Getcatagories1()` / `Getcatagories2()` — distinct category values
- `Getasso1()` — distinct association values
- `getImgLoc()` — example complex query filtered by category and association

### `upload.processor.php`
The main POST controller. Validates upload → generates a unique `{timestamp}-{filename}` → moves file to `/images/` → inserts metadata row → redirects to success page. DB integration is optional but recommended.

---

## Security Notes

- `config.ini` sits inside the web root. In production, move it above the web root or restrict direct HTTP access to `.ini` files via your web server config.
- `upload.processor.php` manually builds INSERT strings. The `quote()` method escapes values, but parameterized prepared statements (MySQLi or PDO) would be more robust.
- `upload.success.php` contains a hardcoded `localhost` URL — update this to match your environment before deploying.

---

## License

This project is licensed under the MIT License. See [LICENSE](LICENSE) for details.
