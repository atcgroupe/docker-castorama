<?php

namespace App\Entity;

use App\Repository\SignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(groups={"create", "update"})
     */
    private $title;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2)
     * @Assert\NotBlank(groups={"create", "update"})
     * @Assert\Positive(groups={"create", "update"})
     */
    private $weight;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank(groups={"create", "update"})
     */
    private $customerReference;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     * @Assert\NotBlank(groups={"create", "update"})
     * @Assert\Positive(groups={"create", "update"})
     */
    private $price;

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
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $width;

    /**
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @ORM\Column(type="smallint")
     */
    private $printFaces;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $material;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $finish;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVariable;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(?string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getCustomerReference(): ?string
    {
        return $this->customerReference;
    }

    public function setCustomerReference(?string $customerReference): self
    {
        $this->customerReference = $customerReference;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

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

    public function getCategory(): ?int
    {
        return $this->category;
    }

    public function setCategory($category): self
    {
        $this->category = $category;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    /**
     * @return string
     */
    public function getChooseImagePath(): string
    {
        return 'build/images/sign/choose/' . $this->getImage();
    }

    public function getCreateRoute(): string
    {
        return sprintf('order_sign_%s_create', $this->type);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getPrintFaces(): ?int
    {
        return $this->printFaces;
    }

    public function setPrintFaces(int $printFaces): self
    {
        $this->printFaces = $printFaces;

        return $this;
    }

    public function getMaterial(): ?string
    {
        return $this->material;
    }

    public function setMaterial(string $material): self
    {
        $this->material = $material;

        return $this;
    }

    public function getFinish(): ?string
    {
        return $this->finish;
    }

    public function setFinish(string $finish): self
    {
        $this->finish = $finish;

        return $this;
    }

    public function getIsVariable(): ?bool
    {
        return $this->isVariable;
    }

    public function setIsVariable(bool $isVariable): self
    {
        $this->isVariable = $isVariable;

        return $this;
    }
}
