<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/{name}', function (Request $request, Response $response, array $args) {
    // Use this to test database connection before continuing development
    $this->get(App\Database::class)->getConnection();

    $name = $args['name'];
    $response->getBody()->write(json_encode("Hello, $name"));
    return $response;
});
