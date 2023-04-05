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
    public function testBasic(): void
    {
        $path = new RoutedPath(new Arrays(['user'=>'def','module'=>'jkl','mno'=>'pqr',]));
        $this->assertEmpty($path->getStaticPath());
        $this->assertEmpty($path->getVirtualPrefix());
        $this->assertEquals('def', $path->getUser());
        $this->assertEmpty($path->getLang());
        $this->assertEmpty($path->getPath());
        $this->assertEquals('jkl', $path->getModule());
        $this->assertEmpty($path->isSingle());
        $this->assertEquals([
            'user' => 'def',
            'lang' => '',
            'path' => [],
            'module' => 'jkl',
            'isSingle' => false,
            'staticPath' => '',
            'virtualPrefix' => '',
        ], $path->getArray());
    }
}
