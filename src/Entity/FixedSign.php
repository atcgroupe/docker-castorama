<?php

namespace App\Entity;

use App\Enum\FixedSignFileType;
use App\Repository\FixedSignRepository;
use App\Service\Sign\FixedSignFileManager;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FixedSignRepository::class)
 * @UniqueEntity("name", message="Un panneau avec ce nom existe déjà.")
 * @UniqueEntity("title", message="Un panneau avec ce titre existe déjà.")
 */
class FixedSign extends AbstractSign
{
    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank(groups={"create", "update"})
     * @Assert\Regex(
     *     pattern="/^[a-z]+(_[a-z]+)*$/", message="Doit être sous la forme xx_xx",
     *     groups={"create", "update"}
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(groups={"create", "update"})
     * @Assert\Positive(groups={"create", "update"})
     */
    private $width;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(groups={"create", "update"})
     * @Assert\Positive(groups={"create", "update"})
     */
    private $height;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank(groups={"create", "update"})
     */
    private $printFaces;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank(groups={"create", "update"})
     */
    private $material;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $finish;

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

    public function __construct()
    {
        $this->setDefaults();
    }

    private function setDefaults(): void
    {
        $this->setIsActive(true);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getDescription(): ?string
    {
        // Todo: add getDescription content
        return '';
    }

    public function getPrintFaces(): ?string
    {
        return $this->printFaces;
    }

    public function setPrintFaces(?string $printFaces): self
    {
        $this->printFaces = $printFaces;

        return $this;
    }

    public function getMaterial(): ?string
    {
        return $this->material;
    }

    public function setMaterial(?string $material): self
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

    /**
     * @return UploadedFile|null
     */
    public function getProductionFile(): ?UploadedFile
    {
        return $this->productionFile;
    }

    /**
     * @param UploadedFile|null $productionFile
     * @return FixedSign
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
     * @return FixedSign
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
     * @return FixedSign
     */
    public function setChooseFile(?UploadedFile $chooseFile): self
    {
        $this->chooseFile = $chooseFile;

        return $this;
    }

    /**
     * @return string
     */
    public function getChooseImagePath(): string
    {
        return sprintf(
            '%s/%s',
            FixedSignFileManager::getPublicFileDir(FixedSignFileType::Choose),
            $this->getFilename(FixedSignFileType::Choose)
        );
    }

    /**
     * @param FixedSignFileType $type
     * @return UploadedFile
     */
    public function getFile(FixedSignFileType $type): UploadedFile
    {
        return match ($type) {
            FixedSignFileType::Production => $this->getProductionFile(),
            FixedSignFileType::Preview => $this->getPreviewFile(),
            FixedSignFileType::Choose => $this->getChooseFile(),
        };
    }

    public function getFilename(FixedSignFileType $type): string
    {
        return match ($type) {
            FixedSignFileType::Production => $this->getName() . '.pdf',
            FixedSignFileType::Preview,
            FixedSignFileType::Choose => $this->getName() . '.jpg',
        };
    }
}
