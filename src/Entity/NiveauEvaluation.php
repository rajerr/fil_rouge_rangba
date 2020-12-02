<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NiveauEvaluationRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=NiveauEvaluationRepository::class)
 * @ApiResource(
* attributes={"security"="is_granted('ROLE_ADMIN')", "security_message"="Seul un admin peut faire cette action.", "pagination_items_per_page"=2},
*     collectionOperations={
*         "post"={ "path"="admin/niveaux",},
*         "get"={"path"="admin/niveaux",
*         "normalization_context"={"groups"={"niveau_read", "niveau_details_read"}}
*         }
*     },
*     
*     itemOperations={
*         "get"={"security_message"="Vous n'avez pas acces a cette ressource.","path"="admin/niveaux/{id}", "normalization_context"={"groups"={"niveau_detail_read"}}}, 
*         "delete"={"path"="admin/niveaux/{id}",},
*         "put"={"path"="admin/niveaux/{id}",},
*  }
 * )
 */
class NiveauEvaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"niveau_read","niveau_detail_read"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"niveau_read","niveau_detail_read"})
     * 
     */
    private $libelle;

    /**
     * @ORM\Column(type="text")
     * @Groups({"niveau_read","niveau_detail_read"})
     * 
     * 
     */
    private $critereEvaluaton;

    /**
     * @ORM\Column(type="text")
     * @Groups({"niveau_read","niveau_detail_read"})
     * 
     */
    private $groupeAction;

    /**
     * @ORM\ManyToOne(targetEntity=Competence::class, inversedBy="niveauEvaluation")
     * @Groups({"niveau_detail_read"})
     * 
     */
    private $competence;

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

    public function getCritereEvaluaton(): ?string
    {
        return $this->critereEvaluaton;
    }

    public function setCritereEvaluaton(string $critereEvaluaton): self
    {
        $this->critereEvaluaton = $critereEvaluaton;

        return $this;
    }

    public function getGroupeAction(): ?string
    {
        return $this->groupeAction;
    }

    public function setGroupeAction(string $groupeAction): self
    {
        $this->groupeAction = $groupeAction;

        return $this;
    }

    public function getCompetence(): ?Competence
    {
        return $this->competence;
    }

    public function setCompetence(?Competence $competence): self
    {
        $this->competence = $competence;

        return $this;
    }
}
