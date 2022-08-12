<?php

namespace App\Entity;

use App\Repository\CustomOrderSignRepository;
use App\Service\String\Formatter;
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
        return $this->getFormattedXmlFilename();
    }
}
