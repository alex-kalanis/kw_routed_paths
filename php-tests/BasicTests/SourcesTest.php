<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_routed_paths\Sources;


class SourcesTest extends CommonTestClass
{
    public function testBasic(): void
    {
        $params = new Sources\Arrays(['abc'=>'def','ghi'=>'jkl','mno'=>'pqr',]);
        $this->assertEquals(['abc'=>'def','ghi'=>'jkl','mno'=>'pqr',], $params->getData());
    }

    public function testArrayAccess1(): void
    {
        $data = new \ArrayObject([
            'abc'=>'/Sources/Request.php?abc=def&ghi[]=jkl&ghi[]=mno&pqr',
            'ghi'=>'/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1',
            'mno'=>'/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr',
        ]);

        $params = new Sources\ArrayAccess($data, 'not in source data', '');
        $this->assertEquals([
            'staticPath' => null, 'virtualPrefix' => null, 'path' => '',
        ], $params->getData());
    }

    public function testArrayAccess2(): void
    {
        $data = new \ArrayObject([
            'abc'=>'/Sources/Request.php?abc=def&ghi[]=jkl&ghi[]=mno&pqr',
            'ghi'=>'/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1',
            'mno'=>'/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr',
        ]);

        $params = new Sources\ArrayAccess($data, 'ghi');
        $this->assertEquals([
            'staticPath' => '/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/',
            'virtualPrefix' => null, 'abc'=>'def', 'ghi' => ['jkl', 'mno'],
            'pqr' => '', 'vars' => '1'
        ], $params->getData());
    }

    /**
     * @param string $uri
     * @param string|null $virtualDir
     * @param string $key
     * @param bool $wantExistence
     * @param string|string[]|null $value
     * @dataProvider requestProvider
     */
    public function testRequest(string $uri, ?string $virtualDir, string $key, bool $wantExistence, $value)
    {
        $params = new Sources\Request($uri, $virtualDir);
        $result = $params->getData();
        $this->assertEquals($wantExistence, isset($result[$key]));
        if ($wantExistence) {
            $this->assertEquals($value, $result[$key]);
        }
    }

    public function requestProvider(): array
    {
        return [
            ['/Sources/Request.php?abc=def&ghi[]=jkl&ghi[]=mno&pqr', null, 'abc', true, 'def'],
            ['/Sources/Request.php?abc=def&ghi[]=jkl&ghi[]=mno&pqr', null, 'lang', false, null],
            ['/Sources/Request.php?abc=def&ghi[]=jkl&ghi[]=mno&pqr', null, 'staticPath', true, '/Sources/Request.php'],
            ['/Sources/Request.php?abc=def&ghi[]=jkl&ghi[]=mno&pqr', null, 'path', false, null],
            ['/Sources/Request.php?abc=def&ghi[]=jkl&ghi[]=mno&pqr', '', 'staticPath', false, null],
            ['/Sources/Request.php?abc=def&ghi[]=jkl&ghi[]=mno&pqr', '', 'path', true, '/Sources/Request.php'],
            ['/Sources/Request.php?abc=def&ghi[]=jkl&ghi[]=mno&pqr', '', 'ghi', true, ['jkl', 'mno']],
            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1', null, 'lang', false, null],
            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', null, 'abc', true, 'def'],
            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1', null, 'staticPath', true, '/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/'],
            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1', null, 'path', false, null],
            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1', null, 'ghi', true, ['jkl', 'mno']],

            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1', '', 'staticPath', false, null],
            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1', '', 'path', true, 'definite/unknown/'],
            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', 'web/', 'abc', true, 'def'],
            ['/web/ms:dfhfdh/l:fdgh/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', 'web/', 'lang', true, 'rrr'],
            ['/web/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', 'web/', 'pqr', true, ''],
            ['/web/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', 'web/', 'path', true, 'definite/unknown/'],
            ['/web/m:stgs/u:gnfnj/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr', 'web/', 'module', true, 'stgs'],
            ['/web/m:stgs/u:gnfnj/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', 'system/', 'staticPath', true, '/web/m:stgs/u:gnfnj/g:/definite/unknown/'],
            ['/web/m:stgs/u:gnfnj/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', 'system/', 'path', false, null],
            ['/m:stgs/u:gnfnj/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr', '/', 'module', true, 'stgs'],

            ['/m:stgs/u:gnfnj/g:/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', '/', 'staticPath', true, ''],
            ['/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', '/', 'staticPath', true, ''],
            ['/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', '/', 'path', true, 'definite/unknown/'],
            ['/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', '', 'staticPath', false, null],
            ['/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', '', 'path', true, '/definite/unknown/'],
            ['/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', null, 'staticPath', true, '/definite/unknown/'],
            ['/definite/unknown/?abc=def&ghi[]=jkl&ghi[]=mno&pqr&vars=1&lang=rrr', null, 'path', false, null],
        ];
    }
}
