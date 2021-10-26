<?php

namespace App\Tests\Service\Fixture;

use App\Service\Fixture\CsvReader;
use PHPUnit\Framework\TestCase;

class CsvReaderTest extends TestCase
{
    public function testGetValidData(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'test');
        file_put_contents($file, "col1;col2;col3\nvalue1-1;value1-2;value1-3\nvalue2-1;value2-2;value2-3");

        $csvReader = new CsvReader();
        $data = $csvReader->getData($file, ["col1", "col2", "col3"]);

        $this->assertCount(2, $data);
        $this->assertEquals(["col1" => "value1-1", "col2" => "value1-2", "col3" => "value1-3"], $data[0]);
        $this->assertEquals(["col1" => "value2-1", "col2" => "value2-2", "col3" => "value2-3"], $data[1]);
    }

    public function testReadError(): void
    {
        $csvReader = new CsvReader();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('The fixture csv file "MyFakeFile" is not readable.');

        $csvReader->getData('MyFakeFile', ["colA", "colB"]);
    }

    public function testMinimumDataLines(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'test');
        file_put_contents($file, "col1;col2;col3\n");

        $csvReader = new CsvReader();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('The fixture csv file "'. $file .'" should contain at least 2 lines.');

        $csvReader->getData($file, ["col1", "col2", "col3"]);
    }

    public function testColumnsDef()
    {
        $file = tempnam(sys_get_temp_dir(), 'test');
        file_put_contents($file, "col1;col2;col3\nvalue1-1;value1-2;value1-3");

        $csvReader = new CsvReader();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The fixture csv file "'. $file .'" columns def does not match required ones.');

        $csvReader->getData($file, ["fakeCol1", "col2", "col3"]);
    }
}
