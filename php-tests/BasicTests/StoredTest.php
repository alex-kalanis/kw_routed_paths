<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_paths\PathsException;
use kalanis\kw_routed_paths\RoutedPath;
use kalanis\kw_routed_paths\Sources\Arrays;
use kalanis\kw_routed_paths\StoreRouted;


class StoredTest extends CommonTestClass
{
    /**
     * @throws PathsException
     */
    public function testBasic(): void
    {
        $path = new RoutedPath(new Arrays(['user' => 'bvdbv']));

        $this->assertEmpty(StoreRouted::getPath());

        StoreRouted::init($path);
        $this->assertNotEmpty(StoreRouted::getPath());
        $xPath = StoreRouted::getPath();
        $this->assertEquals('bvdbv', $xPath->getUser());
    }
}
