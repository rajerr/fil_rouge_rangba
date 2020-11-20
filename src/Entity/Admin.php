<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"statut"=true})
 * @ApiResource(
 * attributes={ "security"="is_granted('ROLE_ADMIN')" , "pagination_items_per_page"=2},
*     collectionOperations={
*         "post"={
*          "security_message"="Vous nêtes pas autorisé à effectuer cette action.",
*          "path"="admin/admins",
*           },
*          "get"={
*           "security_message"="Vous n'avez pas acces a cette ressource.",
*           "path"="admin/admins",
*           "normalization_context"={"groups"={"user_read"}}
*           }
*     },
*     
*     itemOperations={
*         "get"={
*            "security_message"="Vous nêtes pas autorisé à effectuer cette action.",
*            "path"="admin/admins/{id}", 
*            "normalization_context"={"groups"={"user_details_read"}}
*            }, 
*         "archivage"={
*                "method"="put",
*                "security_message"="Seul un admin peut faire cette action.",
*                "path"="admin/admins/{id}/archivage"},
*         "put"={"security_post_denormalize"="is_granted('ROLE_ADMIN')",
*                "security_message"="Vous nêtes pas autorisé à effectuer cette action.",
*                "path"="admin/admins/{id}"}
 *}
 * )
 */
class Admin extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user_read","user_details_read"})
     * 
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
