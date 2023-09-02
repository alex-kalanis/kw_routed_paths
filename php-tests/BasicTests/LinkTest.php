<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_routed_paths\Linking;


class LinkTest extends CommonTestClass
{
    /**
     * @param string[] $path
     * @param string[] $module
     * @param bool $asSingle
     * @param string $user
     * @param string $expected
     * @dataProvider linkMakeProvider
     */
    public function testLinkMake(array $path, array $module, bool $asSingle, string $user, string $expected): void
    {
        $lib = new Linking\Link();
        $this->assertEquals($expected, $lib->link($path, $module, $asSingle, $user));
    }

    /**
     * @param string[] $path
     * @param string[] $module
     * @param bool $asSingle
     * @param string $user
     * @param string $expected
     * @dataProvider linkMakeProvider
     */
    public function testLinkPrefix(array $path, array $module, bool $asSingle, string $user, string $expected): void
    {
        $lib = new Linking\Link('/some-prefix');
        $this->assertEquals('some-prefix/' . $expected, $lib->link($path, $module, $asSingle, $user));
    }

    /**
     * @param string[] $path
     * @param string[] $module
     * @param bool $asSingle
     * @param string $user
     * @param string $expected
     * @dataProvider linkMakeProvider
     */
    public function testLinkExt(array $path, array $module, bool $asSingle, string $user, string $expected): void
    {
        $lib = new Linking\External(new Linking\Link('/some-prefix'), ['foo', 'bar'], $user);
        $this->assertEquals('some-prefix/' . $expected, $lib->link($path, $module, $asSingle));
    }

    public function linkMakeProvider(): array
    {
        return [
            [[], [], true, '', ''],
            [['FooBar', 'Baz'], [], true, '', 'FooBar/Baz'],
            [[], ['FooBar', 'Baz'], true, '', 'ms:foo-bar--baz'],
            [[], [], true, 'anyone', 'u:anyone'],
            [['FooBar', 'Baz'], ['FooBar', 'Baz'], false, 'anyone', 'm:foo-bar--baz/u:anyone/FooBar/Baz'],

//            [[], [], true, '', ''],
        ];
    }
}
