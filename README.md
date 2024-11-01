# Slim Skeleton - Another DAMN framework thingy

This skeleton is a basic backend rest API for slim php skeleton with JWT authentication and minimal dependencies.

## Getting started.
1. run `git clone https://github.com/floweeb/slim-skeleton` to get locally.
2. Install dependencies by calling `php composer.phar install`.
3. Write api routes in the group routes under 'config/routes.php' to ensure 'json/application' content-type.
4. the project is psr-4 compliant so the 'src' folder is where to start on the app logic.
5. It serves the frontend from the public folder just drop your `index.html` and etc. and you are good to go.
    > Note the .gitignore ignores all files in the public folder except: `index.php`, `.htaccess` and `index.html`
    > so watch out in development.

This is specifically works for apache web server, but make sure `mod_rewrite` is enabled.
For other server options contact for more info.

> [!CAUTION]
> NOTE THIS IS A PERSONAL PROJECT USE AT OWN RISK!!

> [!CAUTION]
> At current state it is not PROD ready even by a long shot, add .httaccess for it work.

## Reason for making project.
I needed a basic structure to start projects and get going quickly, WITH MINIMAL DEPENDENCIES.
Here I installed the basic packages:
```
    "slim/slim": "4.*",
    "slim/psr7": "^1.7",
    "php-di/php-di": "^7.0"
```
and locked in the dependencies of the project, if update is needed call:
`php composer.phar update`.

## Database support
It supports both mysql and postgres connections, make sure the postgres ext in
php.ini is uncommented `;extension=pdo_pgsql`, mysql is uncommented by default,
to set the configs, make a `config.ini` file at the root of the project using 
`config.ini.example` as a template.
