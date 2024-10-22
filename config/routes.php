<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteCollectorProxy;


// json return middleware
$json_middleware = function (Request $request, RequestHandler $handler) {
    $response = $handler->handle($request);
    $response = $response->withHeader('Content-Type', RESP_JSON);
    return $response;
};

$app->group('', function (RouteCollectorProxy $group) {

    $group->get('/login', function (Request $request, Response $response, array $args) {
        // Use this to test database connection before continuing development
        $this->get(App\Database::class)->getConnection();
        // use this for JWT creation.    
        $token = $this->get(App\JWT::class)::createToken(['hello' => 'world'], 60 * 60 * 1);

        $name = $args['name'];
        $response->getBody()->write(json_encode(['name' => $name, 'token' => $token]));
        return $response;
    });

    $group->group('/api', function (RouteCollectorProxy $group) {
        $group->get(
            '/test/{name}',
            function (Request $request, Response $response, array $args) {
                $name = $args['name'];

                $response->getBody()->write(json_encode(['name' => $name]));
                return $response;
            }
        );
    })->add(App\Middleware\JWTMiddleware::class);
})->add($json_middleware);


// Serve frontend - this should be last to catch all other routes
$app->get('[/{path:.*}]', function (Request $request, Response $response) {
    $indexPath = APP_ROOT . '/public/frontend/index.html';
    if (!file_exists($indexPath)) {
        throw new \Slim\Exception\HttpInternalServerErrorException($request, "Front end not found, please place file under `public\frontend`");
    }

    $html = file_get_contents($indexPath);
    $response->getBody()->write($html);
    return $response;
});
