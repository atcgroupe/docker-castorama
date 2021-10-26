<?php

namespace App\Tests\Service\Image;

use App\Service\Image\ImageNameFormatter;
use PHPUnit\Framework\TestCase;

class ImageNameFormatterTest extends TestCase
{
    /**
     * @param string $badName
     * @param string $expected
     *
     * @dataProvider nameProvider
     */
    public function testGetFormattedName(string $badName, string $expected): void
    {
        $formatter = new ImageNameFormatter();

        $formattedName = $formatter->getFormattedName($badName);

        $this->assertEquals($expected, $formattedName);
    }

    /**
     * @return array
     */
    public function nameProvider(): array
    {
        return [
            ['NO WHITE SPACE', 'no_white_space'],
            ['STRING IS set TO lowerCase', 'string_is_set_to_lowercase'],
            ['NO - dashes- no -Dashes-no-dashes', 'no_dashes_no_dashes_no_dashes'],
            ['NÔ - ÄÇçÈNT Bêcäüsê THÎS ÏS nÖT À GôöD PRÀCTÎCÉ', 'no_accent_because_this_is_not_a_good_practice'],
            ['no.-points', 'no_points'],
            ['L\'test', 'test'],
            ['test & test', 'test_et_test'],
        ];
    }

    /**
     * @param string $badName
     * @param string $expected
     *
     * @dataProvider filenameProvider
     */
    public function testGetFormattedFilename(string $badName, string $expected): void
    {
        $formatter = new ImageNameFormatter();

        $formattedFilename = $formatter->getFormattedFilename($badName);

        $this->assertEquals($expected, $formattedFilename);
    }

    public function filenameProvider(): array
    {
        return [
            ['//path/to/my/file ïnfô.svg', 'file_info.svg']
        ];
    }
}
