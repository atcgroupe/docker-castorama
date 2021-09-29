<?php

namespace App\Entity;

use App\Repository\SignRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SignRepository::class)
 */
class Sign
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $class;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2)
     */
    private $weight;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $switchFlowBuilder;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $SwitchFlowTemplateFile;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $type;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $customerReference;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getImagePath(): string
    {
        return 'build/images/sign/category/' . $this->getImage();
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getSwitchFlowBuilder(): ?string
    {
        return $this->switchFlowBuilder;
    }

    public function setSwitchFlowBuilder(string $switchFlowBuilder): self
    {
        $this->switchFlowBuilder = $switchFlowBuilder;

        return $this;
    }

    public function getSwitchFlowTemplateFile(): ?string
    {
        return $this->SwitchFlowTemplateFile;
    }

    public function setSwitchFlowTemplateFile(string $SwitchFlowTemplateFile): self
    {
        $this->SwitchFlowTemplateFile = $SwitchFlowTemplateFile;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreateRoute(): string
    {
        return sprintf('order_sign_%s_create', $this->type);
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCustomerReference(): ?string
    {
        return $this->customerReference;
    }

    public function setCustomerReference(string $customerReference): self
    {
        $this->customerReference = $customerReference;

        return $this;
    }
}
