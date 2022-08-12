<?php

namespace App\Entity;

use App\Service\String\Formatter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 */
abstract class AbstractOrderSign implements OrderSignInterface, OrderSignApiInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"api_xml_object"})
     * @SerializedName("signId")
     */
    protected $id;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank
     * @Assert\Positive
     *
     * @Groups({"api_xml_object"})
     */
    protected $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class)
     * @ORM\JoinColumn(nullable=false)
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity=Sign::class)
     * @ORM\JoinColumn(nullable=false)
     */
    protected $sign;

    public function __construct(Order $order, Sign $sign)
    {
        $this->order = $order;
        $this->sign = $sign;
    }

    /**
     * Used for API json data
     *
     * @var string
     */
    protected string $data;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getSign(): ?Sign
    {
        return $this->sign;
    }

    public function setSign(?Sign $sign): self
    {
        $this->sign = $sign;

        return $this;
    }

    /**
     * @return int
     *
     * @Groups({"api_xml_object"})
     */
    public function getOrderId(): int
    {
        return $this->getOrder()->getId();
    }

    /**
     * @return string
     *
     * @Groups({"api_xml_object"})
     */
    public function getTemplateFilename(): string
    {
        return $this->getSign()->getName();
    }

    /**
     * @return string
     *
     * @Groups({"api_xml_object"})
     * @SerializedName("isSignVariable")
     */
    public function isSignVariable(): string
    {
        return $this->getSign()->getIsVariable() ? 'true' : 'false';
    }

    /**
     * @return string
     *
     * @Groups({"api_xml_object"})
     */
    public function getSignName(): string
    {
        return $this->getSign()->getName();
    }

    /**
     * @return string
     *
     * @Groups({"api_xml_object"})
     */
    public function getSignCategoryName(): string
    {
        return Formatter::getNoAccentString($this->getSign()->getCategory()->getLabel());
    }

    /**
     * @return string
     */
    public function getXmlFilename(): string
    {
        return $this->getFormattedXmlFilename('#' . $this->getId());
    }

    /**
     * @param string|null $variableId
     * @return string
     */
    protected function getFormattedXmlFilename(?string $variableId = null): string
    {
        $formattedTitle = strtoupper(Formatter::getNoAccentString($this->getSign()->getTitle()));

        return $variableId ?
            sprintf('%s [%s] %sEX.xml', $formattedTitle, $variableId, $this->getQuantity()) :
            sprintf('%s %sEX.xml', $formattedTitle, $this->getQuantity());
    }
}
