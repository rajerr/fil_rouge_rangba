<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use App\Repository\ProfileSortieRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ORM\Entity(repositoryClass=ProfileSortieRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"statut"=true})
 * @ApiResource(
* attributes={"security"="is_granted('ROLE_ADMIN')","pagination_items_per_page"=2},
*     collectionOperations={
*         "post"={ "security_message"="Seul un admin peut faire cette action.","path"="admin/profileSorties",},
*         "get"={"security_message"="Vous n'avez pas acces a cette ressource.","path"="admin/profileSorties",
*         "normalization_context"={"groups"={"profileSorties_read"}}
*         }
*     },
*     
*     itemOperations={
*         "get"={"security_message"="Vous n'avez pas acces a cette ressource.","path"="admin/profileSorties/{id}", "normalization_context"={"groups"={"profileSorties_detail_read"}}}, 
*         "delete"={"security_message"="Seul un admin peut faire cette action.","path"="admin/profileSorties/{id}",},
*         "put"={"security_message"="Seul un admin peut faire cette action.","path"="admin/profileSorties/{id}",},
*  }
 * )
 */
class ProfileSortie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"profileSorties_read","profileSorties_detail_read"})
     * 
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "libelle can't be null")
     * @Groups({"profileSorties_read","profileSorties_detail_read"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="profileSorttie")
     * @Groups({"profileSorties_read","profileSorties_detail_read"})
     * 
     */
    private $apprenants;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank(message = "libelle can't be null")
     * @Groups({"profileSorties_read","profileSorties_detail_read"})
     */
    private $statut;


    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
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

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
            $apprenant->setProfileSorttie($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getProfileSorttie() === $this) {
                $apprenant->setProfileSorttie(null);
            }
        }

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

}
