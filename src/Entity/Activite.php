<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: ActiviteRepository::class)]
#[Broadcast]
class Activite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_heure = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\ManyToMany(targetEntity: Staff::class)]
    private Collection $staff;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'idA', targetEntity: Staff::class)]
    private Collection $staf; // Changez le nom de l'attribut pour éviter la confusion

    public function __construct()
    {
        $this->staff = new ArrayCollection();
        $this->staf = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
       

        $this->type = $type;

        return $this;
    }
    

    public function getDateHeure(): ?\DateTimeInterface
    {
        return $this->date_heure;
    }

    public function setDateHeure(\DateTimeInterface $date_heure): static
    {
        $this->date_heure = $date_heure;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Staff>
     */
    public function getStaff(): Collection
    {
        return $this->staff;
    }

    public function addStaff(Staff $staff): static
    {
        if (!$this->staff->contains($staff)) {
            $this->staff->add($staff);
        }

        return $this;
    }

    public function removeStaff(Staff $staff): static
    {
        $this->staff->removeElement($staff);

        return $this;
    }

    

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Staff>
     */
    public function getStaf(): Collection
    {
        return $this->staf;
    }

    public function addStaf(Staff $staf): static
    {
        if (!$this->staf->contains($staf)) {
            $this->staf->add($staf);
            $staf->setIdA($this);
        }

        return $this;
    }

    public function removeStaf(Staff $staf): static
    {
        if ($this->staf->removeElement($staf)) {
            // set the owning side to null (unless already changed)
            if ($staf->getIdA() === $this) {
                $staf->setIdA(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return  $this->nom. ' ' . $this->type. '  ('.$this->prix.' )';
    }

}