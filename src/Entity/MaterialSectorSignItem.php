<?php

namespace App\Entity;

use App\Repository\MaterialSectorSignItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaterialSectorSignItemRepository::class)
 */
class MaterialSectorSignItem extends AbstractSignItem
{
    /**
     * @ORM\ManyToOne(targetEntity=MaterialSectorSignItemCategory::class, inversedBy="materialSectorSignItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function getCategory(): ?MaterialSectorSignItemCategory
    {
        return $this->category;
    }

    public function setCategory(?MaterialSectorSignItemCategory $category): self
    {
        $this->category = $category;

        return $this;
    }
}
