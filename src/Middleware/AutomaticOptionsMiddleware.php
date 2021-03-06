<?php

declare(strict_types=1);

namespace Svoboda\Router\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Svoboda\Router\Failure;
use Svoboda\Router\Route\Method;

/**
 * Automatically responds to OPTIONS requests.
 */
class AutomaticOptionsMiddleware implements MiddlewareInterface
{
    /**
     * The response factory.
     *
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * Constructor.
     *
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * @inheritdoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getMethod() !== Method::OPTIONS) {
            return $handler->handle($request);
        }

        /** @var Failure|null $failure */
        $failure = $request->getAttribute(Failure::class);

        if ($failure === null || !$failure->isMethodFailure()) {
            return $handler->handle($request);
        }

        $options = implode(", ", $failure->getAllowedMethods());

        return $this->responseFactory
            ->createResponse(200, "OK")
            ->withHeader("Options", $options);
    }
}
