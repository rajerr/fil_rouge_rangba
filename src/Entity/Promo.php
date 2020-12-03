<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 * @ApiResource(
 * attributes={ "security"="is_granted('ROLE_ADMIN')" , "pagination_items_per_page"=2},
 * 
 *        normalizationContext ={"groups"={"promo_read:read","user_read"}},
*     collectionOperations={
*         "post"={"security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))", "security_message"="Action non authorisée.","path"="/admin/promos"},
*         "get"={"security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))", "security_message"="Vous n'avez pas acces a cette ressource.","path"="/admin/promo"},
*         "list_grp_principal"={
*            "method"="GET",
*            "path"="/admin/promo/principal",
*            "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
*            "security_message"="Vous n'avez pas access à cette Ressource"
*          },
*         "waiting_list_all_students"={
*            "method"="GET",
*            "path"="/admin/promo/apprenants/attente",          
*           "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
*           "security_message"="Vous n'avez pas access à cette Ressource"
*          }
*     },
*     
*     itemOperations={
*         "get"={"security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM')","security_message"="Seul un admin peut faire cette action.","path"="admin/promo/{id}"},
*            "detail_one_grp_principal"={
*              "method"="GET",
*              "path"="/admin/promo/{id}/principal",
*              "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
*              "security_message"="Vous n'avez pas access à cette Ressource"
*            },
*            "referentiel_promo"={
*              "method"="GET",
*              "path"="/admin/promo/{id}/referentiels",          
*              "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
*              "security_message"="Vous n'avez pas access à cette Ressource"
*            },
*            "waiting_list_one_promo"={
*              "method"="GET",
*              "path"="/admin/promo/{id}/apprenants/attente",          
*              "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') )",
*              "security_message"="Vous n'avez pas access à cette Ressource"
*            },
*            "grp_students_of_one_promo"={
*              "method"="GET",
*              "path"="/admin/promo/{id}/groupes/{num}/apprenants",          
*              "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
*              "security_message"="Vous n'avez pas access à cette Ressource"
*            },
*            "formers_one_promo"={
*              "method"="GET",
*              "path"="/admin/promo/{id}/formateurs",          
*              "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
*              "security_message"="Vous n'avez pas access à cette Ressource"
*            },
*         "put"={"security_post_denormalize"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))","security_message"="Seul un admin peut faire cette action.","path"="admin/promo/{id}",},
*            "add_del_students_one_promo"={
*              "method"="PUT",
*              "path"="/admin/promo/{id}/apprenants",          
*              "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
*              "security_message"="Vous n'avez pas access à cette Ressource"
*            },
*            "add_del_formers_one_promo"={
*              "method"="PUT",
*              "path"="/admin/promo/{id}/formateurs",          
*              "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
*              "security_message"="Vous n'avez pas access à cette Ressource"
*            },
*            "put_promo_grp_status"={
*              "method"="PUT",
*              "path"="/admin/promo/{id}/groupes/{num}",          
*              "security"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
*              "security_message"="Vous n'avez pas access à cette Ressource"
*            }
*  }
 * )
 */
class Promo
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
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $referenceAgate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $choixFabrique;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateFin;

    /**
     * @ORM\OneToMany(targetEntity=Referentiel::class, mappedBy="promo")
     */
    private $referentiel;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promo")
     */
    private $groupes;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $avatar;

    public function __construct()
    {
        $this->referentiel = new ArrayCollection();
        $this->groupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getReferenceAgate(): ?string
    {
        return $this->referenceAgate;
    }

    public function setReferenceAgate(string $referenceAgate): self
    {
        $this->referenceAgate = $referenceAgate;

        return $this;
    }

    public function getChoixFabrique(): ?string
    {
        return $this->choixFabrique;
    }

    public function setChoixFabrique(string $choixFabrique): self
    {
        $this->choixFabrique = $choixFabrique;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiel(): Collection
    {
        return $this->referentiel;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiel->contains($referentiel)) {
            $this->referentiel[] = $referentiel;
            $referentiel->setPromo($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiel->removeElement($referentiel)) {
            // set the owning side to null (unless already changed)
            if ($referentiel->getPromo() === $this) {
                $referentiel->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->setPromo($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getPromo() === $this) {
                $groupe->setPromo(null);
            }
        }

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
}
