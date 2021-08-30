<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Wish::class, mappedBy="categ")
     */
    private $categ;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $label;

    public function __construct()
    {
        $this->categ = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Wish[]
     */
    public function getCateg(): Collection
    {
        return $this->categ;
    }

    public function addCateg(Wish $categ): self
    {
        if (!$this->categ->contains($categ)) {
            $this->categ[] = $categ;
            $categ->setCateg($this);
        }

        return $this;
    }

    public function removeCateg(Wish $categ): self
    {
        if ($this->categ->removeElement($categ)) {
            // set the owning side to null (unless already changed)
            if ($categ->getCateg() === $this) {
                $categ->setCateg(null);
            }
        }

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
