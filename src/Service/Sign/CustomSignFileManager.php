<?php

namespace App\Service\Sign;

use App\Entity\Sign;
use App\Enum\CustomSignFileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CustomSignFileManager
{
    private const BASE_FILE_DIR = 'resource/sign';

    public function __construct(
        private readonly string $projectDir,
    ) {
    }

    /**
     * @param Sign $sign
     * @return bool
     */
    public function saveAll(Sign $sign): bool
    {
        $resultProd = $this->save($sign, CustomSignFileType::Production);
        if (!$resultProd) {
            return false;
        }

        $resultPreview = $this->save($sign, CustomSignFileType::Preview);
        if (!$resultPreview) {
            return false;
        }

        return $this->save($sign, CustomSignFileType::Choose);
    }

    /**
     * @param Sign $oldSign
     * @param Sign $sign
     * @return bool
     */
    public function renameAll(Sign $oldSign, Sign $sign): bool
    {
        $resultProd = $this->rename($oldSign, $sign, CustomSignFileType::Production);
        if (!$resultProd) {
            return false;
        }

        $resultPreview = $this->rename($oldSign, $sign, CustomSignFileType::Preview);
        if (!$resultPreview) {
            return false;
        }

        return $this->rename($oldSign, $sign, CustomSignFileType::Choose);
    }

    /**
     * @param Sign $sign
     * @return bool
     */
    public function removeAll(Sign $sign): bool
    {
        $resultProd = $this->remove($sign, CustomSignFileType::Production);
        if (!$resultProd) {
            return false;
        }

        $resultPreview = $this->remove($sign, CustomSignFileType::Preview);
        if (!$resultPreview) {
            return false;
        }

        return $this->remove($sign, CustomSignFileType::Choose);
    }

    /**
     * @param Sign $sign
     * @param CustomSignFileType $type
     * @return bool
     */
    public function save(Sign $sign, CustomSignFileType $type): bool
    {
        $file = $sign->getFile($type);

        try {
            $file->move(
                $this->getAbsoluteFileDir($type),
                $sign->getFilename($type),
            );
        } catch (FileException $exception) {
            return false;
        }

        return true;
    }

    /**
     * @param Sign $sign
     * @param CustomSignFileType $type
     * @return bool
     */
    public function remove(Sign $sign, CustomSignFileType $type): bool
    {
        return unlink($this->getAbsoluteFileDir($type) . '/' . $sign->getFilename($type));
    }

    /**
     * @param Sign $oldSign
     * @param Sign $sign
     * @param CustomSignFileType $type
     * @return bool
     */
    public function rename(Sign $oldSign, Sign $sign, CustomSignFileType $type): bool
    {
        $dir = $this->getAbsoluteFileDir($type);

        return rename(
            $dir . '/' . $oldSign->getFilename($type),
            $dir . '/' . $sign->getFilename($type),
        );
    }

    /**
     * @param CustomSignFileType $type
     * @return string
     */
    public static function getPublicFileDir(CustomSignFileType $type): string
    {
        return self::BASE_FILE_DIR . '/' . $type->getName();
    }

    /**
     * @param CustomSignFileType $type
     * @return string
     */
    private function getAbsoluteFileDir(CustomSignFileType $type): string
    {
        return sprintf(
            '%s/public/%s',
            $this->projectDir,
            self::getPublicFileDir($type)
        );
    }
}
