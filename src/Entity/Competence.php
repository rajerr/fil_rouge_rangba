<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetenceRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"statut"=true})
 * 
 * @ApiResource(
 * attributes={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Seul l'admin a accès à cette ressource", 
 *              "pagination_items_per_page"=2,
 *              "normalization_context"={"groups"={"competences_read", "competences_details_read"}}
 *              },
 * 
 * collectionOperations={
 *          "get"={"path"="/admin/competences"},
 *          "post"={"path"="/admin/competences"}
 * },
 * itemOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM')",
 *              "security_message"="Seul l'admin ou le formateur ou le CM a accès à cette ressource",
 *              "path"="/admin/competences/{id}"
 *                  },
 *          "put"={
 *              "path"="/admin/competences/{id}"
 *                  },
 * 
 *          "list"={
 *              "method"="get", 
 *              "path"="/admin/competences/{id}/groupecompetences/{num}
 *                  "},
 * 
 *          "archivage"={
 *                  "method"="put",
 *                  "path"="/admin/competences/{id}/archivage"}
 * }
 * )
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"competences_read","competences_detail_read", "niveau_read","niveau_detail_read"})
     * 
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "libelle can't be null")
     * @Groups({"competences_read","competences_detail_read", "niveau_read","niveau_detail_read"})
     * 
     * 
     */
    private $libelle;

    /**
     * @ORM\Column(type="text" , nullable=true)
     * @Groups({"competences_read","competences_detail_read", "niveau_read","niveau_detail_read"})
     * 
     */
    private $descriptif;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank(message = "statut can't be null")
     * @Groups({"competences_read","competences_detail_read", "niveau_read","niveau_detail_read"})
     * 
     * 
     */
    private $statut;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, mappedBy="competences")
     * @Groups({"competences_read","competences_detail_read","groupecompetences_detail_read","groupecompetences_read"})
     * 
     */
    private $groupeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=NiveauEvaluation::class, mappedBy="competence")
     * @Groups({"competences_detail_read","groupecompetences_detail_read","niveau_detail_read"})
     * 
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
