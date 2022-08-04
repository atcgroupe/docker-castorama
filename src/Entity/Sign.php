<?php

namespace App\Entity;

use App\Repository\SignRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SignRepository::class)
 */
class Sign extends AbstractSign
{
    /**
     * @ORM\Column(type="string", length=60)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $class;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $switchFlowBuilder;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $SwitchFlowTemplateFile;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $type;

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

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

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
}
