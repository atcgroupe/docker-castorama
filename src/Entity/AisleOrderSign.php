<?php

namespace App\Entity;

use App\Repository\AisleOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AisleOrderSignRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"order", "aisleNumber"},
 *     errorPath="aisleNumber",
 *     message="Un panneau allée avec ce numéro existe déjà dans cette commande"
 * )
 */
class AisleOrderSign extends AbstractAisleOrderSign
{
    private const TYPE = 'aisle';

    /**
     * @ORM\Column(type="boolean")
     */
    private $hideItem2Image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hideItem3Image;

    public function __construct()
    {
        $this->setHideItem2Image(false);
        $this->setHideItem3Image(false);
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return self::TYPE;
    }

    public function getHideItem2Image(): ?bool
    {
        return $this->hideItem2Image;
    }

    public function setHideItem2Image(bool $hideItem2Image): self
    {
        $this->hideItem2Image = $hideItem2Image;

        return $this;
    }

    public function getHideItem3Image(): ?bool
    {
        return $this->hideItem3Image;
    }

    public function setHideItem3Image(bool $hideItem3Image): self
    {
        $this->hideItem3Image = $hideItem3Image;

        return $this;
    }

    /**
     * @return string
     */
    public function getItem1Image(): string
    {
        return sprintf('/build/images/sign/sign/aisle/picto/%s.svg', $this->getItem1ImageName());
    }

    /**
     * @return string
     * @Groups({"api_json_data"})
     * @SerializedName("item1Image")
     */
    public function getItem1ImageName(): string
    {
        return (null === $this->getItem1()) ? 'empty' : $this->getItem1()->getImage();
    }

    /**
     * @return string
     */
    public function getItem2Image(): string
    {
        return sprintf('/build/images/sign/sign/aisle/picto/%s.svg', $this->getItem2ImageName());
    }

    /**
     * @return string
     * @Groups({"api_json_data"})
     * @SerializedName("item2Image")
     */
    public function getItem2ImageName(): string
    {
        return (null === $this->getItem2() || $this->getHideItem2Image()) ? 'empty' : $this->getItem2()->getImage();
    }

    /**
     * @return string
     */
    public function getItem3Image(): string
    {
        return sprintf('/build/images/sign/sign/aisle/picto/%s.svg', $this->getItem3ImageName());
    }

    /**
     * @return string
     * @Groups({"api_json_data"})
     * @SerializedName("item3Image")
     */
    public function getItem3ImageName(): string
    {
        return (null === $this->getItem3() || $this->getHideItem3Image()) ? 'empty' : $this->getItem3()->getImage();
    }
}
