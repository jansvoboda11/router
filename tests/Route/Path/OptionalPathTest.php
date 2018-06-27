<?php

declare(strict_types=1);

namespace SvobodaTest\PsrRouter\Route\Path;

use Svoboda\PsrRouter\Route\Path\AttributePath;
use Svoboda\PsrRouter\Route\Path\EmptyPath;
use Svoboda\PsrRouter\Route\Path\MainPath;
use Svoboda\PsrRouter\Route\Path\OptionalPath;
use Svoboda\PsrRouter\Route\Path\StaticPath;
use SvobodaTest\PsrRouter\TestCase;

class OptionalPathTest extends TestCase
{
    public function test_it_uses_brackets_in_definition()
    {
        $path = new OptionalPath(
            new MainPath(
                new StaticPath("/optional"),
                [],
                new EmptyPath()
            )
        );

        $definition = $path->getDefinition();

        self::assertEquals("[/optional]", $definition);
    }

    public function test_it_makes_attributes_optional()
    {
        $path = new OptionalPath(
            new MainPath(
                new StaticPath(""),
                [
                    new AttributePath("foo", "any"),
                ],
                new EmptyPath()
            )
        );

        $attributes = $path->getAttributes();

        self::assertEquals([
            ["name" => "foo", "type" => "any", "required" => false],
        ], $attributes);
    }

    public function test_it_keeps_optional_attributes_optional()
    {
        $path = new OptionalPath(
            new MainPath(
                new StaticPath(""),
                [],
                new OptionalPath(
                    new MainPath(
                        new StaticPath(""),
                        [
                            new AttributePath("foo", "any"),
                        ],
                        new EmptyPath()
                    )
                )
            )
        );

        $attributes = $path->getAttributes();

        self::assertEquals([
            ["name" => "foo", "type" => "any", "required" => false],
        ], $attributes);
    }
}
