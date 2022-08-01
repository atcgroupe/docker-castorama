<?php

namespace App\Enum;

enum FixedSignFileType
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
     * @return FixedSignFileType|null
     */
    public static function from(string $type): FixedSignFileType|null
    {
        return match ($type) {
            FixedSignFileType::Choose->getName() => FixedSignFileType::Choose,
            FixedSignFileType::Preview->getName() => FixedSignFileType::Preview,
            FixedSignFileType::Production->getName() => FixedSignFileType::Production,
            default => null
        };
    }
}
