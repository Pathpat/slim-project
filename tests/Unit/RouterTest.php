<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Container;
use App\Exceptions\RouteNotFoundException;
use App\Router;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        parent::setUp();
        $this->router = new Router(new Container());
    }

    #[Test]
    public function it_registers_a_route(): void
    {
        //Given that we have a router object
        //With setup Method we get rid the new route() over and over

        //when we call the register method
        $this->router->register('get', '/users', ['Users', 'index']);
        $expected = [
            'get' => [
                '/users' => ['Users', 'index'],
            ],
        ];
        //that we assert route was registered
        $this->assertSame($expected, $this->router->routes());
    }

    #[Test]
    public function it_registers_a_get_route(): void
    {
        $this->router->get('/users', ['Users', 'view']);
        $expected = [
            'get' => [
                '/users' => ['Users', 'view'],
            ],
        ];
        $this->assertSame($expected, $this->router->routes());
    }

    #[Test]
    public function it_registers_a_post_route(): void
    {
        $this->router->post('/users', ['Users', 'store']);

        $expected = [
            'post' => [
                '/users' => ['Users', 'store'],
            ],
        ];

        $this->assertSame($expected, $this->router->routes());
    }

    #[Test]
    public function there_are_no_routes_when_router_is_created(): void
    {
        $router = new Router(new Container());
        $this->assertEmpty($router->routes());
    }

    #[DataProvider('routeNotFoundCases')]
    #[TestDox('It should throw a RouteNotFoundException')]
    #[Test]
    public function it_throws_route_not_found_exception(
        string $requestUri,
        string $requestMethod,
    ): void {
        $users = new class() {
            public function delete(): bool
            {
                return true;
            }
        };
        $this->router->get('/users', [$users::class, 'index']);
        $this->router->post('/users', ['Users', 'store']);

        $this->expectException(RouteNotFoundException::class);
        $this->router->resolve($requestUri, $requestMethod);
    }

    public static function routeNotFoundCases(): array
    {
        return [
            ['/users', 'put'],
            ['/invoices', 'post'],
            ['/users', 'get'],
            ['/users', 'post'],
        ];
    }

    #[Test]
    public function it_resolves_route_from_a_closure(): void
    {
        $this->router->get('/users', fn() => [1, 2, 3]);

        $this->assertSame([1, 2, 3], $this->router->resolve('/users', 'get'));
    }
    
    #[Test]
    public function it_resolves_route(): void
    {
        $users = new class() {
            public function index(): array
            {
                return [1, 2, 3];
            }
        };
        $this->router->post('/users', [$users::class, 'index']);

        $this->assertSame([1, 2, 3], $this->router->resolve('/users', 'post'));
    }

}