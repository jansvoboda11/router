<?php

declare(strict_types=1);

namespace Svoboda\Router\Route;

use Svoboda\Router\Types\Type;

/**
 * The route attribute.
 */
class Attribute
{
    /**
     * Name of the attribute.
     *
     * @var string
     */
    private $name;

    /**
     * Data type of the attribute.
     *
     * @var Type
     */
    private $type;

    /**
     * Is the attribute required?
     *
     * @var bool
     */
    private $required;

    /**
     * Constructor.
     *
     * @param string $name
     * @param Type $type
     * @param bool $required
     */
    public function __construct(string $name, Type $type, bool $required)
    {
        $this->name = $name;
        $this->type = $type;
        $this->required = $required;
    }

    /**
     * Creates the same attribute, but optional (not required).
     *
     * @return Attribute
     */
    public function createOptional(): self
    {
        return new self($this->name, $this->type, false);
    }

    /**
     * Returns the attribute name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the attribute type.
     *
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * Checks whether the attribute is required.
     *
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }
}
