<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FormateurRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"statut"=true})
 * @ApiResource(
 *   attributes={ "security"="is_granted('ROLE_ADMIN')","pagination_items_per_page"=2},
*     collectionOperations={
*         "post"={
*          "security_message"="Seul un admin peut faire cette action.",
*          "path"="admin/formateurs",
*           },
*          "get"={
*           "security_message"="Vous n'avez pas acces a cette ressource.",
*           "path"="admin/formateurs",
*           "normalization_context"={"groups"={"user_read"}}
*           }
*     },
*     
*     itemOperations={
*         "get"={
*            "security_message"="Seul un admin peut faire cette action.",
*            "path"="admin/formateurs/{id}", 
*            "normalization_context"={"groups"={"user_details_read"}}
*            }, 
*         "archivage"={
*                "method"="delete",
*                "security_message"="Seul un admin peut faire cette action.",
*                "path"="admin/formateurs/{id}"},
*         "put"={"security_post_denormalize"="is_granted('ROLE_ADMIN')",
*                "security_message"="Seul un admin peut faire cette action.",
*                "path"="admin/formateurs/{id}"}
 *}
 * )
 */
class Formateur extends User
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
