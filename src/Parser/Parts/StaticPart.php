<?php

declare(strict_types=1);

namespace Svoboda\PsrRouter\Parser\Parts;

use Svoboda\PsrRouter\Compiler\PartsVisitor;

/**
 * Static part of the route.
 */
class StaticPart implements RoutePart
{
    /**
     * @var string
     */
    private $static;

    /**
     * @param string $static
     */
    public function __construct(string $static)
    {
        $this->static = $static;
    }

    /**
     * Returns the static string.
     *
     * @return string
     */
    public function getStatic(): string
    {
        return $this->static;
    }

    /**
     * @inheritdoc
     */
    public function getDefinition(): string
    {
        return $this->static;
    }

    /**
     * @inheritdoc
     */
    public function getAttributes(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function accept(PartsVisitor $visitor): void
    {
        $visitor->enterStatic($this);

        $visitor->leaveStatic($this);
    }
}
