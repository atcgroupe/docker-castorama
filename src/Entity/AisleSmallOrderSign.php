<?php

namespace App\Entity;

use App\Repository\AisleSmallOrderSignRepository;
use App\Service\String\Formatter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=AisleSmallOrderSignRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"order", "aisleNumber"},
 *     errorPath="aisleNumber",
 *     message="Un panneau allée avec ce numéro existe déjà dans cette commande"
 * )
 */
class AisleSmallOrderSign extends AbstractAisleOrderSign
{
    private const TYPE = 'aisleSmall';

    public static function getType(): string
    {
        return self::TYPE;
    }
}
