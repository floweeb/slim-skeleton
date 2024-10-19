<?php

declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use DI\Container;
use App\Database;
use App\JWT;

define('APP_ROOT', dirname(__DIR__));
define('RESP_JSON', 'application/json');

require APP_ROOT . '/vendor/autoload.php';

$container = new Container;
AppFactory::setContainer($container);

// set dB instationation in container.
$container->set(Database::class, function () {
    // parse ini file with the info. to set up the dB.
    $config = parse_ini_file(APP_ROOT . '/config.ini', true)['database'];
    return new Database(
        db_type: $config['db_type'],
        host: $config['host'],
        db_name: $config['db_name'],
        user: $config['user'],
        password: $config['password'],
        port: $config['port']
    );
});
// set JWT sectet in container.
$container->set(JWT::class, function () {
    // parse ini file with the info. to set up the JWT.
    return new JWT(parse_ini_file(APP_ROOT . '/config.ini', true)['JWT']['secret']);
});

$app = AppFactory::create();

$error_middleware = $app->addErrorMiddleware(true, true, true); //set 1st true false in prod.
$error_middleware->getDefaultErrorHandler()->forceContentType(RESP_JSON);  // force json for all errors

// json return middleware
$json_middleware = function (Request $request, RequestHandler $handler) {
    $response = $handler->handle($request);
    $response = $response->withHeader('Content-Type', RESP_JSON);
    return $response;
};
$app->add($json_middleware);

// routes can be added in below file to stop cramping up here.
require APP_ROOT . '/config/routes.php';

$app->run();
