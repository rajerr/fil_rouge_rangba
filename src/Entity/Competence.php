<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 * @ApiResource(
 * attributes={"security"="is_granted('ROLE_ADMIN') ",
 *              "security_message"="Seul l'admin a accès à cette ressource", 
 *              "pagination_items_per_page"=3},
 * collectionOperations={
 *          "get"={"path"="/admin/competences"},
 *          "post"={"path"="/admin/competences"}
 * },
 * itemOperations={
 *          "get"={"security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM')",
 *              "security_message"="Seul l'admin ou le formateur ou le CM a accès à cette ressource",
 *              "path"="/admin/competences/{id}"},
 *          "put"={"path"="/admin/competences/{id}"},
 *          "archivage"={"method"="put",
 *              "path"="/admin/competences/{id}/archivage"}
 * }
 * )
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "libelle can't be null")
     * 
     */
    private $libelle;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptif;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, mappedBy="competences")
     */
    private $groupeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=NiveauEvaluation::class, mappedBy="competence")
     */
    private $niveauEvaluation;

    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
        $this->niveauEvaluation = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection|GroupeCompetence[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->addCompetence($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if ($this->groupeCompetences->removeElement($groupeCompetence)) {
            $groupeCompetence->removeCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection|NiveauEvaluation[]
     */
    public function getNiveauEvaluation(): Collection
    {
        return $this->niveauEvaluation;
    }

    public function addNiveauEvaluation(NiveauEvaluation $niveauEvaluation): self
    {
        if (!$this->niveauEvaluation->contains($niveauEvaluation)) {
            $this->niveauEvaluation[] = $niveauEvaluation;
            $niveauEvaluation->setCompetence($this);
        }

        return $this;
    }

    public function removeNiveauEvaluation(NiveauEvaluation $niveauEvaluation): self
    {
        if ($this->niveauEvaluation->removeElement($niveauEvaluation)) {
            // set the owning side to null (unless already changed)
            if ($niveauEvaluation->getCompetence() === $this) {
                $niveauEvaluation->setCompetence(null);
            }
        }

        return $this;
    }

}
