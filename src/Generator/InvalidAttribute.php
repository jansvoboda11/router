<?php

declare(strict_types=1);

namespace Svoboda\Router\Generator;

use Svoboda\Router\Exception;

/**
 * Invalid attribute encountered during URI generation.
 */
class InvalidAttribute extends Exception
{
    /**
     * The attribute value is missing.
     *
     * @param string $name
     * @return InvalidAttribute
     */
    public static function missing(string $name): self
    {
        return new self("The value for attribute '$name' is missing");
    }

    /**
     * The attribute value has bad format.
     *
     * @param string $name
     * @param string $value
     * @param string $pattern
     * @return InvalidAttribute
     */
    public static function badFormat(string $name, string $value, string $pattern): self
    {
        return new self("The value '$value' of attribute '$name' does not match the specified pattern: $pattern");
    }
}
