<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 * @ApiResource(
 * attributes={
 *              "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))", 
*               "security_message"="Seul un admin peut faire cette action.",
*               "pagination_items_per_page"=2,
*               "normalization_context"={"groups"={"groupe_detail_read", "groupe_read"}}
*               },
    *     collectionOperations={
    *         "post"={
    *              "path"="admin/groupes"
    *                },
    *         "get"={
    *               "path"="admin/groupes"}
    *     },
    *     
    *     itemOperations={
    *         "get"={
    *               "path"="admin/groupes/{id}"
    *               }, 
    *
    *         "get_grp_students"={
    *           "method"="GET",
    *           "path"="admin/groupes/{id}/apprenants",
    *
    *           },
    *
    *         "put"={
    *           "path"="admin/groupes/{id}/apprenants"
    *               },
    *         "delete"={
    *           "path"="admin/groupes/{id}"
    *                   },
    *
    *         "del_grp_student"={
    *           "method"="DELETE",
    *           "path"="admin/groupes/{id}/apprenants/{num}" ,
    *           }
    *     }
 * )
 * 
 */
class Groupe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"groupe_read","groupe_detail_read"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe_read","groupe_detail_read"})
     * 
     */
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"groupe_read","groupe_detail_read"})
     * 
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupes")
     * @Groups({"groupe_read","groupe_detail_read"})
     * 
     */
    private $promo;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="groupes")
     * @Groups({"groupe_read","groupe_detail_read"})
     * 
     */
    private $formateur;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="groupes")
     * @Groups({"groupe_read","groupe_detail_read"})
     * 
     */
    private $apprenant;

    public function __construct()
    {
        $this->formateur = new ArrayCollection();
        $this->apprenant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateur(): Collection
    {
        return $this->formateur;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateur->contains($formateur)) {
            $this->formateur[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        $this->formateur->removeElement($formateur);

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenant(): Collection
    {
        return $this->apprenant;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenant->contains($apprenant)) {
            $this->apprenant[] = $apprenant;
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        $this->apprenant->removeElement($apprenant);

        return $this;
    }
}
