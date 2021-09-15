<?php

namespace App\Entity;

use App\Repository\AisleSignItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AisleSignItemRepository::class)
 */
class AisleSignItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity=AisleSignItemCategory::class, inversedBy="signItems")
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCategory(): ?AisleSignItemCategory
    {
        return $this->category;
    }

    public function setCategory(?AisleSignItemCategory $category): self
    {
        $this->category = $category;

        return $this;
    }
}
