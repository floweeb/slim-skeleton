<?php

declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use DI\ContainerBuilder;

define('APP_ROOT', dirname(__DIR__));
define('RESP_JSON', 'application/json');

require APP_ROOT . '/vendor/autoload.php';

$builder = new ContainerBuilder;
// Adding dB connection details for container to use for starting up class.
$container = $builder->addDefinitions(APP_ROOT . '/config/database_conn.php')
    ->build();
AppFactory::setContainer($container);

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
