<?php

declare(strict_types=1);

use App\Database;

return [
    Database::class => function () {
        // Parse the .ini file to get the database config
        $config = parse_ini_file(APP_ROOT . '/config.ini', true);
        $config = $config['database'];
        return new Database(
            db_type: $config['db_type'],
            host: $config['host'],
            db_name: $config['db_name'],
            user: $config['user'],
            password: $config['password'],
            port: $config['port']
        );
    }
];
