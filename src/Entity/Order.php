<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
//#[Groups('order')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('order')]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('order')]
    private ?\DateTimeInterface $orderDate = null;

    #[ORM\OneToMany(mappedBy: 'order_', targetEntity: OrderedProduct::class, cascade:['persist'], orphanRemoval: true)]
    #[Groups('order')]
    private Collection $orderedProducts;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    #[Groups('order')]
    private ?string $priceNetto = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $priceVat = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    #[Groups('order')]
    private ?string $priceBrutto = null;

    public function __construct()
    {
        $this->orderedProducts = new ArrayCollection();
        $this->setOrderDate(new \DateTime('now'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): static
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * @return Collection<int, OrderedProduct>
     */
    public function getOrderedProducts(): Collection
    {
        return $this->orderedProducts;
    }

    public function addOrderedProduct(OrderedProduct $orderedProduct): static
    {
        if (!$this->orderedProducts->contains($orderedProduct)) {
            $this->orderedProducts->add($orderedProduct);
            $orderedProduct->setOrder($this);
        }

        return $this;
    }

    public function removeOrderedProduct(OrderedProduct $orderedProduct): static
    {
        if ($this->orderedProducts->removeElement($orderedProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderedProduct->getOrder() === $this) {
                $orderedProduct->setOrder(null);
            }
        }

        return $this;
    }

    public function getPriceNetto(): ?string
    {
        return $this->priceNetto;
    }

    public function setPriceNetto(?string $priceNetto): static
    {
        $this->priceNetto = $priceNetto;

        return $this;
    }

    public function getPriceVat(): ?string
    {
        return $this->priceVat;
    }

    public function setPriceVat(?string $priceVat): static
    {
        $this->priceVat = $priceVat;

        return $this;
    }

    public function getPriceBrutto(): ?string
    {
        return $this->priceBrutto;
    }

    public function setPriceBrutto(?string $priceBrutto): static
    {
        $this->priceBrutto = $priceBrutto;

        return $this;
    }
}
