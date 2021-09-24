<?php

namespace App\Service\Image;

class ImageNameFormatter
{
    /**
     * Returns a formatted file name.
     *
     * @param string $filename
     *
     * @return string
     */
    public function getFormattedFilename(string $filename): string
    {
        $info = pathinfo($filename);

        return $this->getFormattedName($info['filename']) . '.' . $info['extension'];
    }

    /**
     * Returns a formatted name from string
     *
     * @param string $name
     *
     * @return string
     */
    public function getFormattedName(string $name): string
    {
        $filter = [
            ' - ' => '_',
            '- ' => '_',
            ' -' => '_',
            ' ' => '_',
            '-' => '_',
            'À' => 'A',
            'Â' => 'A',
            'Ä' => 'A',
            'È' => 'E',
            'É' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'D\'' => '',
            '&' => 'ET',
            'L\'' => '',
            '.' => '',
            'Ç' => 'C',
            'Î' => 'I',
            'Ï' => 'I',
            'Ô' => 'O',
            'Ö' => 'O',
            'Û' => 'U',
            'Ü' => 'U',
        ];

        $searches = [];
        $replaces = [];

        foreach ($filter as $key => $value) {
            $searches[] = $key;
            $replaces[] = $value;
        }

        return strtolower(str_replace($searches, $replaces, strtoupper($name)));
    }
}
