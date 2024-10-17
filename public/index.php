<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use DI\ContainerBuilder;

define('APP_ROOT', dirname(__DIR__));

require APP_ROOT . '/vendor/autoload.php';

$builder = new ContainerBuilder;
$container = $builder->addDefinitions(APP_ROOT . '/config/database_conn.php')
    ->build();
AppFactory::setContainer($container);

$app = AppFactory::create();

$app->get('/{name}', function (Request $request, Response $response, array $args) {
    $pdo = $this->get(App\Database::class);
    $pdo->getConnection();
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

$app->run();
