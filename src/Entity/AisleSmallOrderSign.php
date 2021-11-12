<?php

namespace App\Entity;

use App\Repository\AisleSmallOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

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

    /**
     * @return string
     * @Groups({"api_json_data"})
     */
    public function getFileName(): string
    {
        return sprintf(
            'COMMANDE %s PANNEAU ALLEE %s %sEX.xml',
            $this->getOrderId(),
            $this->getAisleNumber(),
            $this->getQuantity()
        );
    }
}
