<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApprenantRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"statut"=true})
 * @ApiResource(
 * attributes={ "security"="is_granted('ROLE_ADMIN')" , 
 *              "security_message"="Vous nêtes pas autorisé à effectuer cette action.",
 *              "pagination_items_per_page"=2},
*     collectionOperations={
*         "post"={
*          "path"="admin/apprenants",
*           },
*          "get"={
*           "path"="admin/apprenants",
*           "normalization_context"={"groups"={"user_read"}}
*           }
*     },
*     
*     itemOperations={
*         "get"={
*            "path"="admin/apprenants/{id}", 
*            "normalization_context"={"groups"={"user_details_read"}}
*            }, 
*         "archivage"={
*                "method"="delete",
*                "path"="admin/apprenants/{id}"},
*
*         "edit_apprenant"={
*               "method" = "put",
*               "deserialize"=false,
*               "route_name"="edit",
*               }
 *}
 * )
 */
class Apprenant extends User
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
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_read","user_details_read"})
     * 
     */
    private $genre;

    /**
     * @ORM\ManyToOne(targetEntity=ProfileSortie::class, inversedBy="apprenants")
     */
    private $profileSorttie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getProfileSorttie(): ?ProfileSortie
    {
        return $this->profileSorttie;
    }

    public function setProfileSorttie(?ProfileSortie $profileSorttie): self
    {
        $this->profileSorttie = $profileSorttie;

        return $this;
    }

}
