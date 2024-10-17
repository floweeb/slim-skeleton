# Slim Skeleton - Another DAMN framework thingy
> [!CAUTION]
> NOTE THIS IS A PERSONAL PROJECT USE AT OWN RISK!!

> [!CAUTION]
> At current state it is not PROD ready even by a long shot, add .httaccess for it work.

My goal is to have an easy starting point for a REST API, with only json and can serve a front-end.

I needed a basic structure to start projects and get going quickly.
Here I installed the basic packages:
```
    "slim/slim": "4.*",
    "slim/psr7": "^1.7",
    "php-di/php-di": "^7.0"
```
and locked in the dependencies of the project, if update is needed call:
`php composer.phar update`.

## Getting started
to install dependencies call `php composer.phar install`.

### Database support
It supports both mysql and postgres connections, make sure the postgres ext in
php.ini is uncommented `;extension=pdo_pgsql`, mysql is uncommented by default,
to set the configs, make a `config.ini` file at the root of the project using 
`config.ini.example` as a template.
