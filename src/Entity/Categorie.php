<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;


#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ApiResource (
    normalizationContext: ['groups' => ['article','categorie']],
    denormalizationContext: ['groups' => ['article:write']]
)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["article", "categorie"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["categorie"])]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    #[Groups(["categorie"])]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'MaCategorie', targetEntity: Article::class)]
    #[Groups(["categorie"])]
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setMaCategorie($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getMaCategorie() === $this) {
                $article->setMaCategorie(null);
            }
        }

        return $this;
    }
    public function __ToString(): string
    {
        return $this->libelle;
    }

}
