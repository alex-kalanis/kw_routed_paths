<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_paths\PathsException;
use kalanis\kw_routed_paths\Linking\Link;
use kalanis\kw_routed_paths\RoutedPath;
use kalanis\kw_routed_paths\Sources\Request;


class ThereAndBackTest extends CommonTestClass
{
    /**
     * @param string[] $path
     * @param string[] $module
     * @param bool $asSingle
     * @param string $user
     * @throws PathsException
     * @dataProvider linkMakeProvider
     */
    public function testLinkMake(array $path, array $module, bool $asSingle, string $user): void
    {
        $link = new Link();
        $routed = new RoutedPath(new Request($link->link($path, $module, $asSingle, $user), ''));
        $this->assertEquals('', $routed->getStaticPath());
        $this->assertEquals('', $routed->getVirtualPrefix());
        $this->assertEquals($module, $routed->getModule());
        $this->assertEquals($asSingle, $routed->isSingle());
        $this->assertEquals($user, $routed->getUser());
        $this->assertEquals($path, $routed->getPath());
    }

    /**
     * @param string[] $path
     * @param string[] $module
     * @param bool $asSingle
     * @param string $user
     * @throws PathsException
     * @dataProvider linkMakeProvider
     */
    public function testLinkPrefix(array $path, array $module, bool $asSingle, string $user): void
    {
        $link = new Link('somewhere/');
        $routed = new RoutedPath(new Request($link->link($path, $module, $asSingle, $user), 'somewhere/'));
        $this->assertEquals('', $routed->getStaticPath());
        $this->assertEquals('somewhere/', $routed->getVirtualPrefix());
        $this->assertEquals($module, $routed->getModule());
        $this->assertEquals($asSingle, $routed->isSingle());
        $this->assertEquals($user, $routed->getUser());
        $this->assertEquals($path, $routed->getPath());
    }

    public function linkMakeProvider(): array
    {
        return [
            [[], [], false, ''],
            [['FooBar', 'Baz'], [], false, ''],
            [[], ['FooBar', 'Baz'], false, '',],
            [[], [], false, 'anyone'],
            [['FooBar', 'Baz'], ['FooBar', 'Baz'], false, 'anyone'],
            [['FooBar', 'Baz'], ['FooBar', 'Baz'], true, 'anyone'],

//            [[], [], true, '', ''],
        ];
    }

    /**
     * @param string $link
     * @dataProvider linkReverseProvider
     * @throws PathsException
     */
    public function testLinkReverse(string $link): void
    {
        $routed = new RoutedPath(new Request($link, ''));
        $lib = new Link();
        $this->assertEquals($link, $lib->link(
            $routed->getPath(),
            $routed->getModule(),
            $routed->isSingle(),
            $routed->getUser()
        ));
    }

    public function linkReverseProvider(): array
    {
        return [
            ['FooBar/Baz'],
            ['ms:foo-bar--baz'],
            ['u:anyone'],
            ['m:foo-bar--baz/u:anyone/FooBar/Baz'],
        ];
    }
}
