<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_paths\PathsException;
use kalanis\kw_routed_paths\RoutedPath;
use kalanis\kw_routed_paths\Sources\Arrays;


class PathTest extends CommonTestClass
{
    /**
     * @throws PathsException
     */
    public function testBasic1(): void
    {
        $path = new RoutedPath(new Arrays(['user' => 'def', 'module' => 'jkl', 'mno' => 'pqr',]));
        $this->assertEmpty($path->getStaticPath());
        $this->assertEmpty($path->getVirtualPrefix());
        $this->assertEquals('def', $path->getUser());
        $this->assertEmpty($path->getLang());
        $this->assertEmpty($path->getPath());
        $this->assertEquals(['Jkl'], $path->getModule());
        $this->assertFalse($path->isSingle());
        $this->assertEquals([
            'user' => 'def',
            'lang' => '',
            'path' => [],
            'module' => ['Jkl'],
            'isSingle' => false,
            'staticPath' => '',
            'virtualPrefix' => '',
        ], $path->getArray());
    }

    /**
     * @throws PathsException
     */
    public function testBasic2(): void
    {
        $path = new RoutedPath(new Arrays(['lang' => 'bbdf', 'module' => 'jkl-uhb--tgfc-ebds', 'single' => '1', 'path' => 'fdfhg/djhjsfjk/hsdfgh/dfghdf/dfh']));
        $this->assertEmpty($path->getStaticPath());
        $this->assertEmpty($path->getVirtualPrefix());
        $this->assertEmpty($path->getUser());
        $this->assertEquals('bbdf', $path->getLang());
        $this->assertNotEmpty($path->getPath());
        $this->assertEquals(['JklUhb', 'TgfcEbds'], $path->getModule());
        $this->assertTrue($path->isSingle());
        $this->assertEquals([
            'user' => '',
            'lang' => 'bbdf',
            'path' => ['fdfhg', 'djhjsfjk', 'hsdfgh', 'dfghdf', 'dfh'],
            'module' => ['JklUhb', 'TgfcEbds'],
            'isSingle' => true,
            'staticPath' => '',
            'virtualPrefix' => '',
        ], $path->getArray());
    }
}
