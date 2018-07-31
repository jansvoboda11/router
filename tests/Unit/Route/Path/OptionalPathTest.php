<?php

declare(strict_types=1);

namespace SvobodaTest\Router\Unit\Route\Path;

use Svoboda\Router\Route\Attribute;
use Svoboda\Router\Route\Path\AttributePath;
use Svoboda\Router\Route\Path\OptionalPath;
use Svoboda\Router\Route\Path\StaticPath;
use SvobodaTest\Router\TestCase;

class OptionalPathTest extends TestCase
{
    public function test_it_uses_brackets_in_definition()
    {
        $path = new OptionalPath(
            new StaticPath(
                "/optional"
            )
        );

        $definition = $path->getDefinition();

        self::assertEquals("[/optional]", $definition);
    }

    public function test_it_makes_attributes_optional()
    {
        $path = new OptionalPath(
            new AttributePath(
                "foo",
                "any"
            )
        );

        $attributes = $path->getAttributes();

        self::assertEquals([
            new Attribute("foo", "any", false),
        ], $attributes);
    }

    public function test_it_keeps_optional_attributes_optional()
    {
        $path = new OptionalPath(
            new OptionalPath(
                new AttributePath(
                    "foo",
                    "any"
                )
            )
        );

        $attributes = $path->getAttributes();

        self::assertEquals([
            new Attribute("foo", "any", false),
        ], $attributes);
    }
}