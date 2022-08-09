<?php

namespace App\Entity;

use App\Enum\CustomSignFileType;
use App\Repository\SignRepository;
use App\Service\Sign\CustomSignFileManager;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SignRepository::class)
 * @UniqueEntity(
 *     groups={"create", "update"},
 *     fields={"name"},
 *     message="Un panneau avec ce nom existe déjà dans la base."
 * )
 */
class Sign
{
    public const TYPE_CUSTOM = 'custom';

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
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(groups={"create", "update"})
     * @Assert\Regex(
     *     pattern="/^[a-z]+([A-Z][a-z]+)*$/",
     *     groups={"create", "update"},
     *     message="Doit être sous la forme camelCase"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank(groups={"create", "update"})
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(groups={"create", "update"})
     * @Assert\Positive(groups={"create", "update"}, message="Doit être un entier positif")
     */
    private $width;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(groups={"create", "update"})
     * @Assert\Positive(groups={"create", "update"}, message="Doit être un entier positif")
     */
    private $height;

    /**
     * @ORM\Column(type="smallint")
     */
    private $printFaces;

    /**
     * @ORM\Column(type="string", length=255)@Assert\NotBlank(groups={"create", "update"})
     * @Assert\NotBlank(groups={"create", "update"})
     */
    private $material;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $finish;

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
     * @ORM\Column(type="boolean")
     */
    private $isVariable;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity=SignCategory::class, inversedBy="signs")
     */
    private $category;

    /**
     * @var UploadedFile|null
     * @Assert\NotBlank(groups={"create", "production"})
     * @Assert\File(
     *     mimeTypes={"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage="Seuls les fichiers pdf sont acceptés",
     *     groups={"create", "production"}
     * )
     */
    private ?UploadedFile $productionFile;

    /**
     * @var UploadedFile|null
     * @Assert\NotBlank(groups={"create", "preview"})
     * @Assert\Image(
     *     maxSize="1024k",
     *     maxSizeMessage="La taille maxi est de 1Mo",
     *     mimeTypes={"image/jpeg"},
     *     mimeTypesMessage="Seuls les fichiers .jpg sont acceptés",
     *     groups={"create", "preview"},
     * )
     */
    private ?UploadedFile $previewFile;

    /**
     * @var UploadedFile|null
     * @Assert\NotBlank(groups={"create", "choose"})
     * @Assert\File(
     *     maxSize="1024k",
     *     maxSizeMessage="La taille maxi est de 1Mo",
     *     mimeTypes={"image/jpeg"},
     *     mimeTypesMessage="Seuls les fichiers .jpg sont acceptés",
     *     groups={"create", "choose"},
     * )
     * @Assert\Image(
     *     allowLandscape="false",
     *     allowLandscapeMessage="Seul le format carré est autorisé",
     *     allowPortrait="false",
     *     allowPortraitMessage="Seul le format carré est autorisé",
     *     minWidth=299,
     *     minWidthMessage="La largeur de l'image doit être de 300px",
     *     maxWidth=301,
     *     maxWidthMessage="La largeur de l'image doit être de 300px",
     *     minHeight=299,
     *     minHeightMessage="La hauteur de l'image doit être de 300px",
     *     maxHeight=301,
     *     maxHeightMessage="La hauteur de l'image doit être de 300px",
     *     groups={"create", "choose"},
     * )
     */
    private ?UploadedFile $chooseFile;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function setFinish(?string $finish): self
    {
        $this->finish = $finish;

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

    public function getIsVariable(): ?bool
    {
        return $this->isVariable;
    }

    public function setIsVariable(bool $isVariable): self
    {
        $this->isVariable = $isVariable;

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

    public function getCategory(): ?SignCategory
    {
        return $this->category;
    }

    public function setCategory(?SignCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return UploadedFile|null
     */
    public function getProductionFile(): ?UploadedFile
    {
        return $this->productionFile;
    }

    /**
     * @param UploadedFile|null $productionFile
     * @return Sign
     */
    public function setProductionFile(?UploadedFile $productionFile): self
    {
        $this->productionFile = $productionFile;

        return $this;
    }

    /**
     * @return UploadedFile|null
     */
    public function getPreviewFile(): ?UploadedFile
    {
        return $this->previewFile;
    }

    /**
     * @param UploadedFile|null $previewFile
     * @return Sign
     */
    public function setPreviewFile(?UploadedFile $previewFile): self
    {
        $this->previewFile = $previewFile;

        return $this;
    }

    /**
     * @return UploadedFile|null
     */
    public function getChooseFile(): ?UploadedFile
    {
        return $this->chooseFile;
    }

    /**
     * @param UploadedFile|null $chooseFile
     * @return Sign
     */
    public function setChooseFile(?UploadedFile $chooseFile): self
    {
        $this->chooseFile = $chooseFile;

        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayPrintFace(): string
    {
        return match ($this->getPrintFaces()) {
            1 => 'Recto',
            2 => 'Recto/Verso',
        };
    }

    /**
     * Used to select templates and form type in OrderSignController
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->getClass() === CustomOrderSign::class ? self::TYPE_CUSTOM : $this->getName();
    }

    /**
     * @return string
     */
    public function getChooseImagePath(): string
    {
        $fileDir = ($this->isCustomType()) ?
            CustomSignFileManager::getPublicFileDir(CustomSignFileType::Choose) :
            'build/images/sign/choose';

        $filename = ($this->isCustomType()) ?
            $this->getFilename(CustomSignFileType::Choose) :
            $this->getName() . '.jpg';

        return sprintf('%s/%s', $fileDir, $filename);
    }

    /**
     * @return string
     */
    public function getPreviewImagePath(): string
    {
        return sprintf(
            '%s/%s',
            CustomSignFileManager::getPublicFileDir(CustomSignFileType::Preview),
            $this->getFilename(CustomSignFileType::Preview)
        );
    }

    /**
     * @param CustomSignFileType $type
     * @return UploadedFile
     */
    public function getFile(CustomSignFileType $type): UploadedFile
    {
        return match ($type) {
            CustomSignFileType::Production => $this->getProductionFile(),
            CustomSignFileType::Preview => $this->getPreviewFile(),
            CustomSignFileType::Choose => $this->getChooseFile(),
        };
    }

    public function getFilename(CustomSignFileType $type): string
    {
        return match ($type) {
            CustomSignFileType::Production => $this->getName() . '.pdf',
            CustomSignFileType::Preview,
            CustomSignFileType::Choose => $this->getName() . '.jpg',
        };
    }

    /**
     * @return bool
     */
    public function isCustomType(): bool
    {
        return $this->getType() === self::TYPE_CUSTOM;
    }
}
