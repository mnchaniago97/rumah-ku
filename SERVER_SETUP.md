# Server Setup Instructions

## Storage Symlink

After deploying to the server, run the following command to create the storage symlink:

```bash
php artisan storage:link
```

This will create a symbolic link from `public/storage` to `storage/app/public`.

## Alternative: Manual Symlink Creation

If `php artisan storage:link` doesn't work on your server, you can create the symlink manually:

### Linux/Mac:
```bash
ln -s $(pwd)/storage/app/public $(pwd)/public/storage
```

### Shared Hosting (via PHP script):
Create a file `create-symlink.php` in your project root and run it once:

```php
<?php
$target = __DIR__ . '/storage/app/public';
$link = __DIR__ . '/public/storage';

if (file_exists($link)) {
    echo "Symlink already exists or is a directory.\n";
} else {
    if (symlink($target, $link)) {
        echo "Symlink created successfully!\n";
    } else {
        echo "Failed to create symlink. Check permissions.\n";
    }
}
```

Then access it via browser: `https://yourdomain.com/create-symlink.php`

**Important:** Delete `create-symlink.php` after running it for security.

## Permissions

Make sure the storage directory is writable:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Current Upload Configuration

The application now uses the `uploads` disk which stores files directly in `public/storage/` directory, bypassing the symlink requirement. However, the symlink is still useful for:

1. Accessing files uploaded before this change
2. Laravel's built-in storage functions that may still reference the `public` disk

## Troubleshooting

If images still return 404:

1. Check if `public/storage` directory exists and contains the uploaded files
2. Check file permissions (should be 644 for files, 755 for directories)
3. Check web server configuration to ensure it serves files from `public/storage`
