<?php

// On Vercel the deployed filesystem is read-only, so SQLite needs a writable copy in /tmp.
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || is_dir('/var/task')) {
    $sourceDb = __DIR__.'/../database/database.sqlite';
    $tmpDb = '/tmp/database.sqlite';

    if (file_exists($sourceDb) && ! file_exists($tmpDb)) {
        copy($sourceDb, $tmpDb);
    }
}

require __DIR__.'/../public/index.php';
