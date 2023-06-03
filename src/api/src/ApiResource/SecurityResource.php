<?php declare(strict_types = 1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use Symfony\Component\HttpFoundation\Response;

#[
    ApiResource(
        shortName: 'User',
        operations: [
            new Post(
                uriTemplate: '/users/login',
                routeName: 'app_users_login',
                status: Response::HTTP_NO_CONTENT,
                openapi: new Model\Operation(
                    summary: 'Login user',
                    description: 'Login user',
                ),
            ),
            new Get(
                uriTemplate: '/users/logout',
                routeName: 'app_users_logout',
                status: Response::HTTP_NO_CONTENT,
                openapi: new Model\Operation(
                    summary: 'Logout user',
                    description: 'Logout user',
                ),
            ),
        ],
        routePrefix: '/api',
    ),
]
class SecurityResource
{
    #[ApiProperty(identifier: true)]
    public ?string $email = null;

    public ?string $password = null;
}
