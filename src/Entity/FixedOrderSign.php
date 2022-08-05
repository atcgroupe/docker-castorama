<?php

namespace App\Entity;

use App\Enum\FixedSignFileType;
use App\Repository\FixedOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FixedOrderSignRepository::class)
 * @UniqueEntity(
 *     fields={"order", "fixedSign"},
 *     errorPath="quantity",
 *     message="Un panneau identique existe déjà dans cette commande"
 * )
 */
class FixedOrderSign extends AbstractOrderSign implements FixedOrderSignApiInterface
{
    private const SIGN_TYPE = 'FIXED';
    private const TYPE = 'fixed';

    /**
     * @ORM\ManyToOne(targetEntity=FixedSign::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $fixedSign;

    /**
     * @return FixedSign|null
     */
    public function getFixedSign(): ?FixedSign
    {
        return $this->fixedSign;
    }

    public function setFixedSign(?FixedSign $fixedSign): self
    {
        $this->fixedSign = $fixedSign;

        return $this;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return strtoupper(sprintf(
            'COMMANDE %s - %s %s ID%s %sEX.xml',
            $this->getOrderId(),
            $this->getFixedSign()->getCategoryLabel(),
            $this->getFixedSign()->getTitle(),
            $this->getId(),
            $this->getQuantity()
        ));
    }

    /**
     * @return string
     *
     * @Groups({"api_xml_object"})
     */
    public function getSwitchSignType(): string
    {
        return self::SIGN_TYPE;
    }

    /**
     * @return string
     *
     * @Groups({"api_xml_object"})
     */
    public function getProductionFilename(): string
    {
        return $this->getFixedSign()->getFilename(FixedSignFileType::Production);
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return self::TYPE;
    }
}
