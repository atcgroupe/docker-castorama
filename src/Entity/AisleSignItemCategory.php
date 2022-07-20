<?php

namespace App\Entity;

use App\Repository\AisleSignItemCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AisleSignItemCategoryRepository::class)
 */
class AisleSignItemCategory extends AbstractSignItemCategory
{
    /**
     * @ORM\OneToMany(targetEntity=AisleSignItem::class, mappedBy="category")
     */
    private $signItems;

    public function __construct()
    {
        $this->signItems = new ArrayCollection();
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
}
