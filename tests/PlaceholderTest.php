<?php

declare(strict_types=1);

namespace ChangHorizon\BS5Renderers\Tests;

use ChangHorizon\BS5Renderers\HtmlRenderers\Nav\BreadcrumbRenderer;
use PHPUnit\Framework\TestCase;

class PlaceholderTest extends TestCase
{
    public function testPlaceholder(): void
    {
        $this->assertTrue(class_exists(BreadcrumbRenderer::class));
    }
}
