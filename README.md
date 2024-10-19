# Slim Skeleton - Another DAMN framework thingy

My goal is to have an easy starting point for a JSON REST API, that serves a front-end project at none api routes.

> [!CAUTION]
> NOTE THIS IS A PERSONAL PROJECT USE AT OWN RISK!!

> [!CAUTION]
> At current state it is not PROD ready even by a long shot, add .httaccess for it work.


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
To install dependencies call `php composer.phar install`.

you can start at the `config/routes.php` to start making routes to your project.
the project is psr-4 compliant so the 'src' folder is where to start.

### Database support
It supports both mysql and postgres connections, make sure the postgres ext in
php.ini is uncommented `;extension=pdo_pgsql`, mysql is uncommented by default,
to set the configs, make a `config.ini` file at the root of the project using 
`config.ini.example` as a template.
