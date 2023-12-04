<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
#[ApiResource (
    normalizationContext: ['groups' => ['article', 'avis']],
    denormalizationContext: ['groups' => ['article:write']]
)]




class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["article", "avis"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["avis"])]
    private ?string $contenu = null;

    #[ORM\Column(length: 100)]
    #[Groups(["avis"])]
    private ?string $note = null;



    #[ORM\ManyToOne(inversedBy: 'MesAvis')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["avis"])]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'LesAvis')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["avis"])]
    private ?Article $article = null;




    public function getId(): ?int
    {
        return $this->id;
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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): static
    {
        $this->note = $note;

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

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }
    public function __toString(): string
    {
        return $this->contenu;
    }

}
