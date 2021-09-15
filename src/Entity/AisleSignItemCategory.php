<?php

namespace App\Entity;

use App\Repository\AisleSignItemCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AisleSignItemCategoryRepository::class)
 */
class AisleSignItemCategory
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
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity=AisleSignItem::class, mappedBy="category")
     */
    private $signItems;

    /**
     * @ORM\ManyToOne(targetEntity=Sign::class)
     */
    private $sign;

    public function __construct()
    {
        $this->signItems = new ArrayCollection();
    }

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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection|AisleSignItem[]
     */
    public function getSignItems(): Collection
    {
        return $this->signItems;
    }

    public function addSignItem(AisleSignItem $signItem): self
    {
        if (!$this->signItems->contains($signItem)) {
            $this->signItems[] = $signItem;
            $signItem->setCategory($this);
        }

        return $this;
    }

    public function removeSignItem(AisleSignItem $signItem): self
    {
        if ($this->signItems->removeElement($signItem)) {
            // set the owning side to null (unless already changed)
            if ($signItem->getCategory() === $this) {
                $signItem->setCategory(null);
            }
        }

        return $this;
    }

    public function getSign(): ?Sign
    {
        return $this->sign;
    }

    public function setSign(?Sign $sign): self
    {
        $this->sign = $sign;

        return $this;
    }
}
