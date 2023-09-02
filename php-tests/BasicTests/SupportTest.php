<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_routed_paths\Support;


class SupportTest extends CommonTestClass
{
    /**
     * @param string $in
     * @param string[] $expected
     * @dataProvider nameFromTemplateProvider
     */
    public function testNameFromTemplate(string $in, array $expected): void
    {
        $this->assertEquals($expected, Support::moduleNameFromRequest($in));
    }

    public function nameFromTemplateProvider(): array
    {
        return [
            ['whatever-for-name', ['WhateverForName']],
            ['whatever--for--name', ['Whatever', 'For', 'Name']],
        ];
    }

    /**
     * @param string[] $in
     * @param string $expected
     * @dataProvider normalizeLinkProvider
     */
    public function testLinkModule(array $in, string $expected): void
    {
        $this->assertEquals($expected, Support::requestFromModuleName($in));
    }

    public function normalizeLinkProvider(): array
    {
        return [
            [['FooBar0Baz'], 'foo-bar0-baz'],
            [['Nope-Yep'], 'nope-yep'],
            [['Θεσσαλονίκη'], 'θεσσαλονίκη'], // not ASCII
            [['FooBar', 'Baz'], 'foo-bar--baz'],
        ];
    }
}
