<?php

namespace App\Service\Sign;

use App\Entity\FixedSign;
use App\Enum\FixedSignFileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FixedSignFileManager
{
    private const BASE_FILE_DIR = 'resource/sign';

    public function __construct(
        private readonly string $projectDir,
    ) {
    }

    /**
     * @param FixedSign $sign
     * @return bool
     */
    public function saveAll(FixedSign $sign): bool
    {
        $resultProd = $this->save($sign, FixedSignFileType::Production);
        if (!$resultProd) {
            return false;
        }

        $resultPreview = $this->save($sign, FixedSignFileType::Preview);
        if (!$resultPreview) {
            return false;
        }

        return $this->save($sign, FixedSignFileType::Choose);
    }

    /**
     * @param FixedSign $oldSign
     * @param FixedSign $sign
     * @return bool
     */
    public function renameAll(FixedSign $oldSign, FixedSign $sign): bool
    {
        $resultProd = $this->rename($oldSign, $sign, FixedSignFileType::Production);
        if (!$resultProd) {
            return false;
        }

        $resultPreview = $this->rename($oldSign, $sign, FixedSignFileType::Preview);
        if (!$resultPreview) {
            return false;
        }

        return $this->rename($oldSign, $sign, FixedSignFileType::Choose);
    }

    /**
     * @param FixedSign $sign
     * @return bool
     */
    public function removeAll(FixedSign $sign): bool
    {
        $resultProd = $this->remove($sign, FixedSignFileType::Production);
        if (!$resultProd) {
            return false;
        }

        $resultPreview = $this->remove($sign, FixedSignFileType::Preview);
        if (!$resultPreview) {
            return false;
        }

        return $this->remove($sign, FixedSignFileType::Choose);
    }

    /**
     * @param FixedSign $sign
     * @param FixedSignFileType $type
     * @return bool
     */
    public function save(FixedSign $sign, FixedSignFileType $type): bool
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
     * @param FixedSign $sign
     * @param FixedSignFileType $type
     * @return bool
     */
    public function remove(FixedSign $sign, FixedSignFileType $type): bool
    {
        return unlink($this->getAbsoluteFileDir($type) . '/' . $sign->getFilename($type));
    }

    /**
     * @param FixedSign $oldSign
     * @param FixedSign $sign
     * @param FixedSignFileType $type
     * @return bool
     */
    public function rename(FixedSign $oldSign, FixedSign $sign, FixedSignFileType $type): bool
    {
        $dir = $this->getAbsoluteFileDir($type);

        return rename(
            $dir . '/' . $oldSign->getFilename($type),
            $dir . '/' . $sign->getFilename($type),
        );
    }

    /**
     * @param FixedSignFileType $type
     * @return string
     */
    public static function getPublicFileDir(FixedSignFileType $type): string
    {
        return self::BASE_FILE_DIR . '/' . $type->getName();
    }

    /**
     * @param FixedSignFileType $type
     * @return string
     */
    private function getAbsoluteFileDir(FixedSignFileType $type): string
    {
        return sprintf(
            '%s/public/%s/%s',
            $this->projectDir,
            self::BASE_FILE_DIR,
            $type->getName()
        );
    }
}
