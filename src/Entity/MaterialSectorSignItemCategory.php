<?php

namespace App\Entity;

use App\Repository\MaterialSectorSignItemCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaterialSectorSignItemCategoryRepository::class)
 */
class MaterialSectorSignItemCategory extends AbstractSignItemCategory
{
    /**
     * @ORM\OneToMany(targetEntity=MaterialSectorSignItem::class, mappedBy="category", orphanRemoval=true)
     */
    private $materialSectorSignItems;

    public function __construct()
    {
        $this->materialSectorSignItems = new ArrayCollection();
    }

    /**
     * @return Collection|MaterialSectorSignItem[]
     */
    public function getMaterialSectorSignItems(): Collection
    {
        return $this->materialSectorSignItems;
    }

    public function addMaterialSectorSignItem(MaterialSectorSignItem $materialSectorSignItem): self
    {
        if (!$this->materialSectorSignItems->contains($materialSectorSignItem)) {
            $this->materialSectorSignItems[] = $materialSectorSignItem;
            $materialSectorSignItem->setCategory($this);
        }

        return $this;
    }

    public function removeMaterialSectorSignItem(MaterialSectorSignItem $materialSectorSignItem): self
    {
        if ($this->materialSectorSignItems->removeElement($materialSectorSignItem)) {
            // set the owning side to null (unless already changed)
            if ($materialSectorSignItem->getCategory() === $this) {
                $materialSectorSignItem->setCategory(null);
            }
        }

        return $this;
    }
}
