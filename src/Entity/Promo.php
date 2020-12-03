<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 * @ApiResource(
 * attributes={ 
 *              "security"="is_granted('ROLE_ADMIN')", 
 *              "pagination_items_per_page"=2, 
 *              "security_message"="Action non authorisée.",
 *              "normalizationContext" ={"groups"={"promo_read", "promo_detail_read", "user_read"}}
 *            },
*     collectionOperations={
*         "post"={
*               "path"="/admin/promos"
*                },
*
*         "get"={
*               "path"="/admin/promos"
*               },
*
*         "get_principal_promo"={
*               "method"="GET",
*               "path"="/admin/promos/{id}/principal"
*               },
*
*           "get_apprenant_attente_promo"={
*               "method"="GET",
*               "path"="/admin/promos/apprenants/attente"
*          }
*     },
*     
*     itemOperations={
*         "get_one_promo"={
*               "method"="GET",
*                "path"="admin/promo/{id}"
*               },
*
*            "promo_principal"={
*              "method"="GET",
*              "path"="/admin/promo/{id}/principal"
*               },
*            "get_referentiel_promo"={
*              "method"="GET",
*              "path"="/admin/promo/{id}/referentiels"          
*            },
*
*            "promo_apprenant_attente"={
*              "method"="GET",
*              "path"="/admin/promo/{id}/apprenants/attente"          
*            },
*           
*            "promo_groupe_apprenant"={
*              "method"="GET",
*              "path"="/admin/promo/{id}/groupes/{num}/apprenants"          
*            },
**            "get_promo_formateurs"={
*              "method"="GET",
*              "path"="/admin/promo/{id}/formateurs"          
*            },
*
*         "promo_ref"={
*              "method"="put",
*               "path"="admin/promo/{id}/referentiels"
*                },
*
*         "promo_formateurs"={
*              "method"="put",
*               "path"="admin/promo/{id}/formateurs"
*                },
*
*         "promo_apprenants"={
*              "method"="put",
*               "path"="admin/promo/{id}/apprenants"
*                },
*
*         "promo_groupes"={
*              "method"="put",
*               "path"="admin/promo/{id}/groupes/{num}"
*                },
*  }
 * )
 */
class Promo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"promo_read","promo_details_read"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"promo_read","promo_details_read"})
     * @Assert\NotBlank(message = "langue can't be null")
     * 
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"promo_read","promo_details_read"})
     * @Assert\NotBlank(message = "titre can't be null")
     * 
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     * @Groups({"promo_read","promo_details_read"})
     * @Assert\NotBlank(message = "description can't be null")
     * 
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"promo_read","promo_details_read"})
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"promo_read","promo_details_read"})
     * @Assert\NotBlank(message = "reference agate can't be null")
     */
    private $referenceAgate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "fabrique can't be null")
     * @Groups({"promo_read","promo_details_read"})
     */
    private $choixFabrique;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"promo_read","promo_details_read"})
     * @Assert\NotBlank(message = "date can't be null")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"promo_read","promo_details_read"})
     * @Assert\NotBlank(message = "date can't be null")
     */
    private $dateFin;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promo")
     */
    private $groupes;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"promo_read","promo_details_read"})
     * 
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity=Referentiel::class, mappedBy="promo")
     */
    private $referentiels;

    public function __construct()
    {
        $this->referentiel = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
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
        $data = stream_get_contents($this->avatar);
        fclose($this->avatar);

       return base64_encode($data);
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->setPromo($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->removeElement($referentiel)) {
            // set the owning side to null (unless already changed)
            if ($referentiel->getPromo() === $this) {
                $referentiel->setPromo(null);
            }
        }

        return $this;
    }

}
