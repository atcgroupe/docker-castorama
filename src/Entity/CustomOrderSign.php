<?php

namespace App\Entity;

use App\Repository\CustomOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CustomOrderSignRepository::class)
 * @UniqueEntity(
 *     fields={"order", "sign"},
 *     errorPath="quantity",
 *     message="Un panneau identique existe déjà dans cette commande"
 * )
 */
class CustomOrderSign extends AbstractOrderSign
{
    /**
     * @return string
     */
    public function getXmlFilename(): string
    {
        return sprintf(
            'COMMANDE %s - %s %sEX.xml',
            $this->getOrderId(),
            $this->getSignName(),
            $this->getQuantity()
        );
    }
}
