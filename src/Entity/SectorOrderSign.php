<?php

namespace App\Entity;

use App\Repository\SectorOrderSignRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=SectorOrderSignRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class SectorOrderSign extends AbstractOrderSign
{
    private const TYPE = 'sector';

    private $option;

    /**
     * @ORM\ManyToOne(targetEntity=SectorSignItem::class)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $item1;

    /**
     * @ORM\ManyToOne(targetEntity=SectorSignItem::class)
     */
    private $item2;

    /**
     * @ORM\PostLoad()
     */
    public function initializeOption()
    {
        $this->option = $this->getItem2() === null ? 1 : 2;
    }

    /**
     * @return mixed
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * @param mixed $option
     */
    public function setOption($option): void
    {
        $this->option = $option;
    }

    public function getItem1(): ?SectorSignItem
    {
        return $this->item1;
    }

    public function setItem1(?SectorSignItem $item1): self
    {
        $this->item1 = $item1;

        return $this;
    }

    public function getItem2(): ?SectorSignItem
    {
        return $this->item2;
    }

    public function setItem2(?SectorSignItem $item2): self
    {
        $this->item2 = $item2;

        return $this;
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ($this->option === 2 && $this->item2 === null) {
            $context->buildViolation('Cette valeur ne doit pas être vide.')
                ->atPath('item2')
                ->addViolation();
        }
    }
}
