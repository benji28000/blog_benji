<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 100)]
    private ?string $mdp = null;

    #[ORM\Column(length: 100)]
    private ?string $mail = null;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Article::class)]
    private Collection $MesArticles;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Avis::class)]
    private Collection $MesAvis;

    public function __construct()
    {
        $this->MesArticles = new ArrayCollection();
        $this->MesAvis = new ArrayCollection();
    }
    public function __ToString(): string
    {
        return $this->pseudo;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getMesArticles(): Collection
    {
        return $this->MesArticles;
    }

    public function addMesArticle(Article $mesArticle): static
    {
        if (!$this->MesArticles->contains($mesArticle)) {
            $this->MesArticles->add($mesArticle);
            $mesArticle->setUtilisateur($this);
        }

        return $this;
    }

    public function removeMesArticle(Article $mesArticle): static
    {
        if ($this->MesArticles->removeElement($mesArticle)) {
            // set the owning side to null (unless already changed)
            if ($mesArticle->getUtilisateur() === $this) {
                $mesArticle->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getMesAvis(): Collection
    {
        return $this->MesAvis;
    }

    public function addMesAvi(Avis $mesAvi): static
    {
        if (!$this->MesAvis->contains($mesAvi)) {
            $this->MesAvis->add($mesAvi);
            $mesAvi->setUtilisateur($this);
        }

        return $this;
    }

    public function removeMesAvi(Avis $mesAvi): static
    {
        if ($this->MesAvis->removeElement($mesAvi)) {
            // set the owning side to null (unless already changed)
            if ($mesAvi->getUtilisateur() === $this) {
                $mesAvi->setUtilisateur(null);
            }
        }

        return $this;
    }
}
