<?php

declare(strict_types=1);

namespace App\Middleware;

use App\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class JWTMiddleware
{
    public function __construct(JWT $jwt) {}
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        // check authorization header
        $auth_header = $request->getHeaderLine('Authorization');
        if (strpos($auth_header, 'Bearer ') === false) {
            throw new \Slim\Exception\HttpUnauthorizedException($request, 'Authorization header not found or invalid.');
        }

        $validated = jwt::validateToken(trim(substr($auth_header, 7)));
        if (!$validated) {
            throw new \Slim\Exception\HttpUnauthorizedException($request, 'Authorization header not found or invalid.');
        }

        $response = $handler->handle($request);
        return $response;
    }
}
