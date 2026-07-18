# Deployment Guide — cPanel (No Terminal)

## Prerequisites

1. **cPanel access** with File Manager or FTP
2. **MySQL database** created in cPanel (note DB name, user, password)
3. **Email account** set up in cPanel (support@managingteam.info)
4. **Wildcard subdomain** `*.managingteam.info` pointing to `/public_html/public`

## Step 1: Upload Files

1. Upload `managingteam-deploy.zip` to your cPanel `/public_html/` directory
2. Use **File Manager** → Extract the zip (or unzip via FTP)
3. Move everything from the extracted folder into `/public_html/` so that:
   - `public/index.php` → `/public_html/public/index.php`
   - `app/`, `config/`, `vendor/` → `/public_html/app/`, `/public_html/config/`, etc.

## Step 2: Configure `.env`

1. Copy `.env.example` to `.env` in `/public_html/`
2. Edit `.env` in **File Manager** and set these values:

```ini
APP_ENV=production
APP_DEBUG=false
APP_URL=https://managingteam.info

# Database — use your cPanel MySQL credentials
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_cpanel_db_name
DB_USERNAME=your_cpanel_db_user
DB_PASSWORD=your_cpanel_db_password

# Session domain — REQUIRED for subdomain cookies
SESSION_DOMAIN=.managingteam.info

# Mail — SET THE PASSWORD from cPanel Email Accounts
MAIL_PASSWORD=your_smtp_password_here
```

## Step 3: Import Database

1. In cPanel, open **phpMyAdmin**
2. Select your database
3. Click **Import** → Choose `database/managingteam_celeb.sql` → **Go**
4. Wait for import to complete

## Step 4: Clean Stale Caches

In **File Manager**, delete these files/folders:
- `storage/framework/views/` — delete all `.php` files (keep `.gitignore`)
- `storage/framework/cache/data/` — delete everything inside
- `bootstrap/cache/` — delete all `.php` files (keep `.gitignore`)

## Step 5: Verify Public Access

1. Ensure `public/storage` symlink exists (create if missing — see below)
2. Visit `https://managingteam.info` — should show landing page
3. Visit `https://managingteam.info/admin` — should show login page

### Create Storage Symlink (if not present)
If the `public/storage` folder doesn't exist:
1. Visit `https://managingteam.info/setup.php` once (file is included in zip)
2. Or create it manually in File Manager:
   - Delete `public/storage` if it exists as a real folder
   - Ask your hosting support to create a symlink: `public/storage → ../storage/app/public`

## Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@managingteam.info | admin123! |
| Fan (Jennie) | sarah@demo.com | demo1234! |
| Fan (Jennie) | james@demo.com | demo1234! |
| Fan (Jennie) | emily@demo.com | demo1234! |
| Fan (Jungkook) | mia@demo.com | demo1234! |
| Fan (Jungkook) | daniel@demo.com | demo1234! |
| Fan (Lisa) | sophia@demo.com | demo1234! |
| Fan (Lisa) | noah@demo.com | demo1234! |
| Fan (Lisa) | olivia@demo.com | demo1234! |

## Step 6: Test Subdomain Routing

Visit `https://jennie.managingteam.info` — should show Jennie Kim's fan portal.

If you get a 500 error:
1. Check `storage/logs/laravel.log` for the error message
2. Delete all `.php` files in `storage/framework/views/` again
3. Clear `storage/framework/cache/data/` again
4. Ensure `.env` has correct DB credentials

## Step 7: Configure Mail

1. Login at `https://managingteam.info/admin`
2. Go to **System → Mail Settings**
3. Enter your SMTP credentials (set in Step 2)
4. Click **Send Test Email** to verify

## Step 8: Secure Setup

1. Delete `public/setup.php` (if it still exists)
2. Verify `APP_DEBUG=false` in `.env`

## Troubleshooting

**500 error on every page**: Stale compiled views. Delete `storage/framework/views/*.php`.

**404 on all pages**: The `.htaccess` rewrite rule isn't working. Ensure `/public_html/.htaccess` exists:
```apache
RewriteEngine On
RewriteCond %{REQUEST_URI} !^/public/
RewriteRule ^(.*)$ public/$1 [L]
```

**Cannot login (419 expired)**: Check `SESSION_DOMAIN` in `.env` — must be uncommented for production:
```
SESSION_DOMAIN=.managingteam.info
```

**Emails not sending**: Set `MAIL_PASSWORD` in `.env`, or configure via Admin → System → Mail Settings.

**Blank white page**: Check `storage/logs/laravel.log` for PHP errors.
