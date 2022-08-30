<?php

namespace App\Enum;

enum CustomSignFileType
{
    case Production;
    case Preview;
    case Choose;

    /**
     * @return string
     */
    public function getName(): string
    {
        return strtolower($this->name);
    }

    /**
     * @param string $type
     * @return CustomSignFileType|null
     */
    public static function from(string $type): CustomSignFileType|null
    {
        return match ($type) {
            CustomSignFileType::Choose->getName() => CustomSignFileType::Choose,
            CustomSignFileType::Preview->getName() => CustomSignFileType::Preview,
            CustomSignFileType::Production->getName() => CustomSignFileType::Production,
            default => null
        };
    }
}
