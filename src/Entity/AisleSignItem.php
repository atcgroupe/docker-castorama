<?php

namespace App\Entity;

use App\Repository\AisleSignItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AisleSignItemRepository::class)
 */
class AisleSignItem extends AbstractSignItem
{
    /**
     * @ORM\Column(type="string", length=60)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=AisleSignItemCategory::class, inversedBy="signItems")
     */
    private $category;

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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
