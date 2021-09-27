<?php

namespace App\Entity;

use App\Repository\AisleSmallOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AisleSmallOrderSignRepository::class)
 */
class AisleSmallOrderSign extends AbstractAisleOrderSign
{
    private const TYPE = 'aisleSmall';

    public static function getType(): string
    {
        return self::TYPE;
    }
}
