<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Quack::class, mappedBy="tags")
     */
    private $tagname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $categoryName;

    public function __construct()
    {
        $this->tagname = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Quack[]
     */
    public function getTagname(): Collection
    {
        return $this->tagname;
    }

    public function addTagname(Quack $tagname): self
    {
        if (!$this->tagname->contains($tagname)) {
            $this->tagname[] = $tagname;
        }

        return $this;
    }

    public function removeTagname(Quack $tagname): self
    {
        $this->tagname->removeElement($tagname);

        return $this;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(?string $categoryName): self
    {
        $this->categoryName = $categoryName;

        return $this;
    }
    public function __toString(){
        return $this->categoryName;
    }
}
