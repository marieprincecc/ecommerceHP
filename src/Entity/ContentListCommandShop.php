<?php

namespace App\Entity;

use App\Repository\ContentListCommandShopRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContentListCommandShopRepository::class)
 */
class ContentListCommandShop
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=CommandListProduct::class, inversedBy="contentListCommandShops")
     * @ORM\JoinColumn(nullable=false)
     */
    private $listProduct;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getListProduct(): ?CommandListProduct
    {
        return $this->listProduct;
    }

    public function setListProduct(?CommandListProduct $listProduct): self
    {
        $this->listProduct = $listProduct;

        return $this;
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

    public function getTotal()
    {
        return $this->product->getPrice() * $this->quantity;
    }
}
