<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'MesArticles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Avis::class)]
    private Collection $LesAvis;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $MaCategorie = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $imageUrl = null;



    public function __construct()
    {
        $this->LesAvis = new ArrayCollection();
    }
    public function __ToString(): string
    {
        return $this->titre;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getLesAvis(): Collection
    {
        return $this->LesAvis;
    }

    public function addLesAvi(Avis $lesAvi): static
    {
        if (!$this->LesAvis->contains($lesAvi)) {
            $this->LesAvis->add($lesAvi);
            $lesAvi->setArticle($this);
        }

        return $this;
    }

    public function removeLesAvi(Avis $lesAvi): static
    {
        if ($this->LesAvis->removeElement($lesAvi)) {
            // set the owning side to null (unless already changed)
            if ($lesAvi->getArticle() === $this) {
                $lesAvi->setArticle(null);
            }
        }

        return $this;
    }

    public function getMaCategorie(): ?Categorie
    {
        return $this->MaCategorie;
    }

    public function setMaCategorie(?Categorie $MaCategorie): static
    {
        $this->MaCategorie = $MaCategorie;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }


}
