<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfileRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;


/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"statut"=true})
 * @ApiResource(
 * attributes={"security"="is_granted('ROLE_ADMIN')", "security_message"="Seul un admin peut faire cette action.", "pagination_items_per_page"=2},
    *     collectionOperations={
    *         "post"={ "path"="admin/profiles",},
    *         "get"={"path"="admin/profiles",
    *         "normalization_context"={"groups"={"profil_read"}}
    *         }
    *     },
    *     
    *     itemOperations={
    *         "get"={"security_message"="Vous n'avez pas acces a cette ressource.","path"="admin/profiles/{id}", "normalization_context"={"groups"={"profil_detail_read"}}}, 
    *         "delete"={"path"="admin/profiles/{id}",},
    *         "put"={"path"="admin/profiles/{id}",},
    *  }
 * )
 */
class Profile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"profil_read","profil_detail_read"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "libelle can't be null")
     * @Groups({"profil_read","profil_detail_read"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="profile")
     * @Groups({"profil_detail_read"})
     * 
     */
    private $users;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"profil_read","profil_detail_read"})
     * 
     */
    private $statut;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setProfile($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfile() === $this) {
                $user->setProfile(null);
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
