<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use DI\ContainerBuilder;

define('APP_ROOT', dirname(__DIR__));

require APP_ROOT . '/vendor/autoload.php';

$builder = new ContainerBuilder;
// Adding dB connection details for container to use for starting up class.
$container = $builder->addDefinitions(APP_ROOT . '/config/database_conn.php')
    ->build();
AppFactory::setContainer($container);

$app = AppFactory::create();

$error_middleware = $app->addErrorMiddleware(true, true, true); //set to false, the first one I think, in prod.
$error_middleware->getDefaultErrorHandler()->forceContentType('application/json');


$app->get('/{name}', function (Request $request, Response $response, array $args) {
    // Use this to test database connection before continuing
    $this->get(App\Database::class)->getConnection();

    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->run();
