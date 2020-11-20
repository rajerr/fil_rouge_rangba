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
 * attributes={ "security"="is_granted('ROLE_ADMIN')" , "pagination_items_per_page"=2},
*     collectionOperations={
*         "post"={
*          "security_message"="Vous nêtes pas autorisé à effectuer cette action.",
*          "path"="admin/apprenants",
*           },
*          "get"={
*           "security_message"="Vous n'avez pas acces a cette ressource.",
*           "path"="admin/apprenants",
*           "normalization_context"={"groups"={"user_read"}}
*           }
*     },
*     
*     itemOperations={
*         "get"={
*            "security_message"="Vous nêtes pas autorisé à effectuer cette action.",
*            "path"="admin/apprenants/{id}", 
*            "normalization_context"={"groups"={"user_details_read"}}
*            }, 
*         "archivage"={
*                "method"="delete",
*                "security_message"="Vous nêtes pas autorisé à effectuer cette action.",
*                "path"="admin/apprenants/{id}"},
*         "put"={"security_post_denormalize"="is_granted('ROLE_ADMIN')",
*                "security_message"="Vous nêtes pas autorisé à effectuer cette action.",
*                "path"="admin/apprenants/{id}"}
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

}
