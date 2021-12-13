<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandShopRepository;
use DateTime;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * @ORM\Entity(repositoryClass=CommandShopRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class CommandShop
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commandShops")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToOne(targetEntity=CommandDeliveryAddress::class, mappedBy="commandShop", cascade={"persist", "remove"})
     */
    private $commandDeliveryAddress;

    /**
     * @ORM\OneToOne(targetEntity=CommandListProduct::class, mappedBy="commandShop", cascade={"persist", "remove"})
     */
    private $commandListProduct;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        if(empty($this->createdAt))
        {
            $this->createdAt = new DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCommandDeliveryAddress(): ?CommandDeliveryAddress
    {
        return $this->commandDeliveryAddress;
    }

    public function setCommandDeliveryAddress(CommandDeliveryAddress $commandDeliveryAddress): self
    {
        // set the owning side of the relation if necessary
        if ($commandDeliveryAddress->getCommandShop() !== $this) {
            $commandDeliveryAddress->setCommandShop($this);
        }

        $this->commandDeliveryAddress = $commandDeliveryAddress;

        return $this;
    }

    public function getCommandListProduct(): ?CommandListProduct
    {
        return $this->commandListProduct;
    }

    public function setCommandListProduct(CommandListProduct $commandListProduct): self
    {
        // set the owning side of the relation if necessary
        if ($commandListProduct->getCommandShop() !== $this) {
            $commandListProduct->setCommandShop($this);
        }

        $this->commandListProduct = $commandListProduct;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }
}
