<?php

namespace App\Service\Fixture;

use InvalidArgumentException;
use RuntimeException;

class CsvReader
{
    /**
     * @param string $filename
     * @param array  $columns
     *
     * @return array
     */
    public function getData(string $filename, array $columns): array
    {
        $rawCsvData = $this->getFile($filename);

        $this->checkMinimumDataLines($filename, $rawCsvData);
        $data = $this->getParsedData($rawCsvData);
        $this->checkColumnsDef($filename, $columns, $data[0]);

        array_walk($data, function (&$item) use ($data) {
            $item = array_combine($data[0], $item);
        });

        $data = $this->getColumnsData($data, $columns);

        array_shift($data);

        return $data;
    }

    /**
     * @param string $filename
     *
     * @return array
     *
     * @throws RuntimeException
     */
    private function getFile(string $filename): array
    {
        if (!is_readable($filename)) {
            throw new RuntimeException(sprintf('The fixture csv file "%s" is not readable.', $filename));
        }

        return file($filename);
    }

    /**
     * @param string $filename
     * @param array  $rawData
     *
     * @throws RuntimeException
     */
    private function checkMinimumDataLines(string $filename, array $rawData): void
    {
        if (count($rawData) < 2) {
            throw new RuntimeException(
                sprintf('The fixture csv file "%s" should contain at least 2 lines.', $filename)
            );
        }
    }

    /**
     * @param string $filename
     * @param array  $columns
     * @param array  $data
     *
     * @throws InvalidArgumentException
     */
    private function checkColumnsDef(string $filename, array $columns, array $data): void
    {
        foreach ($columns as $column) {
            if (!in_array($column, $data, true)) {
                throw new InvalidArgumentException(
                    sprintf('The fixture csv file "%s" columns def does not match required ones.', $filename)
                );
            }
        }
    }

    /**
     * @param array $rawData
     *
     * @return array
     */
    private function getParsedData(array $rawData): array
    {
        $data = [];
        foreach ($rawData as $rawLine) {
            $data[] = str_getcsv($rawLine, ";");
        }

        return $data;
    }

    /**
     * @param array $data
     * @param array $columns
     *
     * @return array
     */
    private function getColumnsData(array $data, array $columns): array
    {
        $filteredData = [];

        foreach ($data as $line) {
            $filteredData[] = $this->getFilteredDataLine($line, $columns);
        }

        return $filteredData;
    }

    /**
     * @param array $line
     * @param array $columns
     *
     * @return array
     */
    private function getFilteredDataLine(array $line, array $columns): array
    {
        $data = [];
        foreach ($line as $key => $item) {
            if (in_array($key, $columns)) {
                $data[$key] = $item;
            }
        }

        return $data;
    }
}
