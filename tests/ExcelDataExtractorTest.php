<?php

namespace App\Tests;

use App\Utils\ExcelDataExtractor;
use Box\Spout\Common\Entity\Row;
use PHPUnit\Framework\TestCase;

class ExcelDataExtractorTest extends TestCase
{
    public function testStructureData()
    {
        $in = [
            ['h1', 'h2'],
            ['d1', 'd2'],
        ];
        $expected = [
            [
                'h1' => 'd1',
                'h2' => 'd2',
            ],
        ];
        $res = ExcelDataExtractor::structureData($in);
        $this->assertEquals($expected, $res);
    }
}
