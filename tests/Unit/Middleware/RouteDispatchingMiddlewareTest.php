<?php

declare(strict_types=1);

namespace SvobodaTest\Router\Unit\Middleware;

use Mockery;
use Mockery\MockInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Svoboda\Router\Match;
use Svoboda\Router\Middleware\RouteDispatchingMiddleware;
use Svoboda\Router\Route\Path\StaticPath;
use Svoboda\Router\Route\Route;
use SvobodaTest\Router\TestCase;

class RouteDispatchingMiddlewareTest extends TestCase
{
    /** @var MockInterface|RequestHandlerInterface */
    private $handler;

    /** @var RouteDispatchingMiddleware */
    private $middleware;

    protected function setUp()
    {
        $this->handler = Mockery::mock(RequestHandlerInterface::class);
        $this->middleware = new RouteDispatchingMiddleware();
    }

    public function test_it_calls_default_handler_without_match()
    {
        $request = self::createRequest("GET", "/users");

        $this->handler
            ->shouldReceive("handle")
            ->with($request)
            ->andReturn(self::createResponse(201, "Created", "Default Handler Response"))
            ->once();

        $response = $this->middleware->process($request, $this->handler);

        self::assertEquals(201, $response->getStatusCode());
        self::assertEquals("Default Handler Response", $response->getBody());
    }

    public function test_it_delegates_to_match_middleware_when_present()
    {
        $request = self::createRequest("GET", "/users");

        $this->handler->shouldNotReceive("handle");

        /** @var MockInterface|RequestHandlerInterface $handler */
        $handler = Mockery::mock(RequestHandlerInterface::class);
        $handler
            ->shouldReceive("handle")
            ->with($request)
            ->andReturn(self::createResponse(201))
            ->once();

        $route = new Route("GET", new StaticPath("/users"), $handler);

        $match = Mockery::mock(Match::class);
        $match
            ->shouldReceive("getRoute")
            ->andReturn($route)
            ->once();
        $match
            ->shouldReceive("getRequest")
            ->andReturn($request)
            ->once();

        $request = $request->withAttribute(Match::class, $match);

        $response = $this->middleware->process($request, $this->handler);

        self::assertEquals(201, $response->getStatusCode());
    }
}
