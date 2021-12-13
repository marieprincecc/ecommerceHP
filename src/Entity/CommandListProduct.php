<?php

namespace App\Entity;

use App\Repository\CommandListProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandListProductRepository::class)
 */
class CommandListProduct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=CommandShop::class, inversedBy="commandListProduct", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $commandShop;

    /**
     * @ORM\OneToMany(targetEntity=ContentListCommandShop::class, mappedBy="listProduct")
     */
    private $contentListCommandShops;

    public function __construct()
    {
        $this->contentListCommandShops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommandShop(): ?CommandShop
    {
        return $this->commandShop;
    }

    public function setCommandShop(CommandShop $commandShop): self
    {
        $this->commandShop = $commandShop;

        return $this;
    }

    /**
     * @return Collection|ContentListCommandShop[]
     */
    public function getContentListCommandShops(): Collection
    {
        return $this->contentListCommandShops;
    }

    public function addContentListCommandShop(ContentListCommandShop $contentListCommandShop): self
    {
        if (!$this->contentListCommandShops->contains($contentListCommandShop)) {
            $this->contentListCommandShops[] = $contentListCommandShop;
            $contentListCommandShop->setListProduct($this);
        }

        return $this;
    }

    public function removeContentListCommandShop(ContentListCommandShop $contentListCommandShop): self
    {
        if ($this->contentListCommandShops->removeElement($contentListCommandShop)) {
            // set the owning side to null (unless already changed)
            if ($contentListCommandShop->getListProduct() === $this) {
                $contentListCommandShop->setListProduct(null);
            }
        }

        return $this;
    }
}
