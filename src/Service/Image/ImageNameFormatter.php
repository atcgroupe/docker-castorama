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
            'à' => 'a',
            'â' => 'a',
            'ä' => 'a',
            'è' => 'e',
            'é' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'd\'' => '',
            '&' => 'et',
            'l\'' => '',
            '.' => '',
            'ç' => 'c',
            'î' => 'i',
            'ï' => 'i',
            'ô' => 'o',
            'ö' => 'o',
            'û' => 'u',
            'ü' => 'u',
        ];

        $searches = [];
        $replaces = [];

        foreach ($filter as $key => $value) {
            $searches[] = $key;
            $replaces[] = $value;
        }

        return str_replace($searches, $replaces, mb_strtolower( $name, "UTF-8"));
    }
}
