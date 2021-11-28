<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Users;
use App\Entity\Category;
use App\Entity\Service;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArchiveRepository::class)
 */
class Archive
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Code_archive;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $intitule_archive;

    /**
     * @ORM\Column(type="date")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="date")
     */
    private $date_archivage;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, inversedBy="archive")
     */
    private $parent;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="archive")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="archive")
     * @ORM\JoinColumn(nullable=false)
     */
    private $service;

    public function __construct()
    {
        $this->parent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeArchive(): ?string
    {
        return $this->Code_archive;
    }

    public function setCodeArchive(string $Code_archive): self
    {
        $this->Code_archive = $Code_archive;

        return $this;
    }



    /**
     * @return Collection|Users[]
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function addParent(Users $parent): self
    {
        if (!$this->parent->contains($parent)) {
            $this->parent[] = $parent;
        }

        return $this;
    }

    public function removeParent(Users $parent): self
    {
        $this->parent->removeElement($parent);

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getIntituleArchive(): ?string
    {
        return $this->intitule_archive;
    }

    public function setIntituleArchive(string $intitule_archive): self
    {
        $this->intitule_archive = $intitule_archive;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateArchivage(): ?\DateTimeInterface
    {
        return $this->date_archivage;
    }

    public function setDateArchivage(\DateTimeInterface $date_archivage): self
    {
        $this->date_archivage = $date_archivage;

        return $this;
    }
}
