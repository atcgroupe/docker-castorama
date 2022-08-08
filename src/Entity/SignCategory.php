<?php

namespace App\Entity;

use App\Repository\SignCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SignCategoryRepository::class)
 */
class SignCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=Sign::class, mappedBy="category")
     */
    private $signs;

    public function __construct()
    {
        $this->signs = new ArrayCollection();
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

    /**
     * @return Collection|Sign[]
     */
    public function getSigns(): Collection
    {
        return $this->signs;
    }

    public function addSign(Sign $sign): self
    {
        if (!$this->signs->contains($sign)) {
            $this->signs[] = $sign;
            $sign->setCategory($this);
        }

        return $this;
    }

    public function removeSign(Sign $sign): self
    {
        if ($this->signs->removeElement($sign)) {
            // set the owning side to null (unless already changed)
            if ($sign->getCategory() === $this) {
                $sign->setCategory(null);
            }
        }

        return $this;
    }
}
