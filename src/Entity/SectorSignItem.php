<?php

namespace App\Entity;

use App\Repository\SectorSignItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SectorSignItemRepository::class)
 */
class SectorSignItem extends AbstractSignItem
{
    public const BLUE = 'blue';
    public const GREY = 'grey';

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $color;

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }
}
