<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="profile", type="string")
 * @ORM\DiscriminatorMap({"ADMIN" = "User", "APPRENANT" = "Apprenant", "FORMATEUR" = "Formateur", "CM" = "Cm"})
 * @ApiResource(
 * attributes={ "security"="is_granted('ROLE_ADMIN')","pagination_items_per_page"=5},
*     collectionOperations={
*         "post"={
*          "security_message"="Seul un admin peut faire cette action.",
*          "path"="admin/users",
*           },
*          "get"={
*           "security_message"="Vous n'avez pas acces a cette ressource.",
*           "path"="admin/users",
*           "normalization_context"={"groups"={"user_read"}}
*           }
*     },
*     
*     itemOperations={
*         "get"={
*            "security_message"="Seul un admin peut faire cette action.",
*            "path"="admin/users/{id}", 
*            "normalization_context"={"groups"={"user_details_read"}}
*            }, 
*         "delete"={
*                   "security_message"="Seul un admin peut faire cette action.",
*                   "path"="admin/users/{id}"},
*         "put"={"security_post_denormalize"="is_granted('ROLE_ADMIN')",
*                "security_message"="Seul un admin peut faire cette action.",
*                "path"="admin/users/{id}"}
 *}
 *  )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user_read","user_details_read"})
     * 
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message = "username can't be null")
     * @Groups({"user_read","user_details_read"})
     * 
     */
    protected $username;

    /**
     */
    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "password can't be null")
     * 
     */
    protected $password;

    /**
     * @ORM\Column(type="blob")
     * @Assert\NotBlank(message = "avatar can't be null")
     * @Groups({"user_details_read"})
     */
    protected $avatar;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "nom can't be null")
     * @Groups({"user_read","user_details_read"})
     */
    protected $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "prenom can't be null")
     * @Groups({"user_read","user_details_read"})
     */
    protected $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Email can't be null")
     * @Assert\Email(
     *  message = "Email '{{ value }}' is not valid!."
     *)
     *@Groups({"user_details_read", "user_read"})
     */
    protected $email;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"user_details_read"})
     * 
     */
    protected $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Profile::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user_details_read"})
     */
    protected $profile;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "telephone can't be null")
     * @Groups({"user_read","user_details_read"})
     */
    protected $telephone;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_' . $this->profile->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(?int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
}
