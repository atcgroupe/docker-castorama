<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    private const DELIVERY_DELAY = 21;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"api"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Groups({"api"})
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups({"api"})
     */
    private $creationTime;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups({"api"})
     */
    private $lastUpdateTime;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date(groups={"update_admin"})
     *
     * @Groups({"api"})
     */
    private $deliveryDate;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\NotBlank(
     *     groups={"order_send"},
     *     message="Le numéro de commande Castorama est obligatoire pour valider une commande"
     * )
     *
     * @Groups({"api"})
     */
    private $customerReference;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Member::class, inversedBy="orders")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $member;

    /**
     * @ORM\ManyToOne(targetEntity=OrderStatus::class)
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"api"})
     */
    private $status;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    public function __construct()
    {
        $this->creationTime = new \DateTime('now');
        $this->lastUpdateTime = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreationTime(): ?\DateTimeInterface
    {
        return $this->creationTime;
    }

    public function setCreationTime(\DateTimeInterface $creationTime): self
    {
        $this->creationTime = $creationTime;

        return $this;
    }

    public function getLastUpdateTime(): ?\DateTimeInterface
    {
        return $this->lastUpdateTime;
    }

    public function setLastUpdateTime(\DateTimeInterface $lastUpdateTime): self
    {
        $this->lastUpdateTime = $lastUpdateTime;

        return $this;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(?\DateTimeInterface $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCalculatedDeliveryDate(): \DateTimeInterface
    {
        $now = new \DateTime('now');
        $date = $now->modify(sprintf('+%s day', self::DELIVERY_DELAY));

        switch($date->format('N')) {
            case '6':
                $date->modify('+2 day');
                break;
            case '7':
                $date->modify('+1 day');
                break;
        }

        return $date;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function getMemberDisplayName(): string
    {
        return ($this->getMember() !== null) ? $this->getMember()->getDisplayName() : 'Membre supprimé';
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getStatus(): ?OrderStatus
    {
        return $this->status;
    }

    public function setStatus(?OrderStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
