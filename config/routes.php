<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

$app->get('/', function (Request $request, Response $response, array $args) {
    // Use this to test database connection before continuing development
    $this->get(App\Database::class)->getConnection();
    // use this for JWT creation.    
    $token = $this->get(App\JWT::class)::createToken(['hello' => 'world'], 60 * 60 * 1);

    $name = $args['name'];
    $response->getBody()->write(json_encode(['name' => $name, 'token' => $token]));
    return $response;
});


$app->group('/api', function (RouteCollectorProxy $group) {
    $group->get(
        '/test/{name}',
        function (Request $request, Response $response, array $args) {
            $name = $args['name'];

            $response->getBody()->write(json_encode(['name' => $name]));
            return $response;
        }
    );
})->add(App\Middleware\JWTMiddleware::class);
